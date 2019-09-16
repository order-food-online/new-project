var Lot = require("../models/lot");
var Comment = require("../models/comment");
var Review = require("../models/review");
// all the middleware goes here
var middlewareObj = {};

//Lot loggin check ownership middleware
middlewareObj.checkLotOwnership = function(req, res, next){
	if(req.isAuthenticated()){
		Lot.findById(req.params.id, function(err, foundLot){
			if(err || !foundLot){
				req.flash("error", "Lot Listing not found");
				res.redirect("back");
			}else {
				// does user own Lot Listing?
				if(foundLot.author.id.equals(req.user._id) || req.user.isAdmin){
					next();
				} else {
					req.flash("error", "You don't have permission to do that!");
					res.redirect("back");
				}
			}
		});
	       }else {
			    req.flash("error", "You need to be logged in to do that!");
				res.redirect("back");
	    }
}

//comments loggin check ownership middleware
middlewareObj.checkCommentOwnership = function(req, res, next){
	if(req.isAuthenticated()){
		Comment.findById(req.params.comment_id, function(err, foundComment){
			if(err || !foundComment){
				req.flash("error", "Comment not found!");
				res.redirect("back");
			}else {
				// does user own comment?
				if(foundComment.author.id.equals(req.user._id) || req.user.isAdmin){
					next();
				}else {
					req.flash("error", "You don't have permission to do that!");
					res.redirect("back");
				}
			}
		});
	}else {
		req.flash("error", "You Need to be logged in to do that!");
		res.redirect("back");
	}
}


//review ownership
middlewareObj.checkReviewOwnership = function(req, res, next) {
    if(req.isAuthenticated()){
        Review.findById(req.params.review_id, function(err, foundReview){
            if(err || !foundReview){
                res.redirect("back");
            }  else {
                // does user own the comment?
                if(foundReview.author.id.equals(req.user._id)) {
                    next();
                } else {
                    req.flash("error", "You don't have permission to do that");
                    res.redirect("back");
                }
            }
        });
    } else {
        req.flash("error", "You need to be logged in to do that");
        res.redirect("back");
    }
};

// review ownership
middlewareObj.checkReviewExistence = function (req, res, next) {
    if (req.isAuthenticated()) {
        Lot.findById(req.params.id).populate("reviews").exec(function (err, foundLot) {
            if (err || !foundLot) {
                req.flash("error", "Lot Listing not found.");
                res.redirect("back");
            } else {
                // check if req.user._id exists in foundCampground.reviews
                var foundUserReview = foundLot.reviews.some(function (review) {
                    return review.author.id.equals(req.user._id);
                });
                if (foundUserReview) {
                    req.flash("error", "You already wrote a review.");
                    return res.redirect("/lots/" + foundLot._id);
                }
                // if the review was not found, go to the next middleware
                next();
            }
        });
    } else {
        req.flash("error", "You need to login first.");
        res.redirect("back");
    }
};
//isLogged in Authentication middleware
middlewareObj.isLoggedIn = function(req, res, next){
	if(req.isAuthenticated()){
		return next();
	}
	req.flash("error", "You need to be logged in to do that!");
	res.redirect("/login");
}

//middleware exports router
module.exports = middlewareObj;