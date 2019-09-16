var express = require("express");
var router = express.Router({mergeParams: true});
var Lot = require("../models/lot");
var Review = require("../models/review");
var middleware = require("../middleware");

// Reviews Index
router.get("/", function (req, res) {
    Lot.findById(req.params.id).populate({
        path: "reviews",
        options: {sort: {createdAt: -1}} // sorting the populated reviews array to show the latest first
    }).exec(function (err, lot) {
        if (err || !lot) {
            req.flash("error", err.message);
            return res.redirect("back");
        }
        res.render("reviews/index", {lot: lot});
    });
});

// Reviews New
router.get("/new", middleware.isLoggedIn, middleware.checkReviewExistence, function (req, res) {
    // middleware.checkReviewExistence checks if a user already reviewed the lot listing, only one review per user is allowed
    Lot.findById(req.params.id, function (err, lot) {
        if (err) {
            req.flash("error", err.message);
            return res.redirect("back");
        }
        res.render("reviews/new", {lot: lot});

    });
});

// Reviews Create
router.post("/", middleware.isLoggedIn, middleware.checkReviewExistence, function (req, res) {
    //lookup lot listings using ID
    Lot.findById(req.params.id).populate("reviews").exec(function (err, lot) {
        if (err) {
            req.flash("error", err.message);
            return res.redirect("back");
        }
        Review.create(req.body.review, function (err, review) {
            if (err) {
                req.flash("error", err.message);
                return res.redirect("back");
            }
            //add author username/id and associated lot listing to the review
            review.author.id = req.user._id;
            review.author.username = req.user.username;
            review.lot = lot;
            //save review
            review.save();
            lot.reviews.push(review);
            // calculate the new average review for the campground
            lot.rating = calculateAverage(lot.reviews);
            //save campground
            lot.save();
            req.flash("success", "Your review has been successfully added.");
            res.redirect('/lots/' + lot._id);
        });
    });
});

// Reviews Edit
router.get("/:review_id/edit", middleware.checkReviewOwnership, function (req, res) {
    Review.findById(req.params.review_id, function (err, foundReview) {
        if (err) {
            req.flash("error", err.message);
            return res.redirect("back");
        }
        res.render("reviews/edit", {lot_id: req.params.id, review: foundReview});
    });
});

// Reviews Update
router.put("/:review_id", middleware.checkReviewOwnership, function (req, res) {
    Review.findByIdAndUpdate(req.params.review_id, req.body.review, {new: true}, function (err, updatedReview) {
        if (err) {
            req.flash("error", err.message);
            return res.redirect("back");
        }
        Lot.findById(req.params.id).populate("reviews").exec(function (err, lot) {
            if (err) {
                req.flash("error", err.message);
                return res.redirect("back");
            }
            // recalculate lots listings average
            lot.rating = calculateAverage(lot.reviews);
            //save changes
            lot.save();
            req.flash("success", "Your review was successfully edited.");
            res.redirect('/lots/' + lot._id);
        });
    });
});

// Reviews Delete
router.delete("/:review_id", middleware.checkReviewOwnership, function (req, res) {
    Review.findByIdAndRemove(req.params.review_id, function (err) {
        if (err) {
            req.flash("error", err.message);
            return res.redirect("back");
        }
        Lot.findByIdAndUpdate(req.params.id, {$pull: {reviews: req.params.review_id}}, {new: true}).populate("reviews").exec(function (err, lot) {
            if (err) {
                req.flash("error", err.message);
                return res.redirect("back");
            }
            // recalculate lot listing average
            lot.rating = calculateAverage(lot.reviews);
            //save changes
            lot.save();
            req.flash("success", "Your review was deleted successfully.");
            res.redirect("/lots/" + req.params.id);
        });
    });
});

function calculateAverage(reviews) {
    if (reviews.length === 0) {
        return 0;
    }
    var sum = 0;
    reviews.forEach(function (element) {
        sum += element.rating;
    });
    return sum / reviews.length;
}

module.exports = router;