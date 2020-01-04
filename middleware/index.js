var Restaurant = require("../models/restaurant");
var Comment = require("../models/comment");
var Review = require("../models/review");
var User = require("../models/user");
// all the middleware goes here
var middlewareObj = {};

//Restaurant loggin check ownership middleware
middlewareObj.checkRestaurantOwnership = function(req, res, next){
	if(req.isAuthenticated()){
		Restaurant.findById(req.params.id, function(err, foundRestaurant){
			if(err || !foundRestaurant){
				req.flash("error", "Restaurant Listing not found");
				res.redirect("back");
			}else {
				// does user own Restaurant Listing?
				if(foundRestaurant.author.id.equals(req.user._id) || req.user.isAdmin){
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
        Restaurant.findById(req.params.id).populate("reviews").exec(function (err, foundRestaurant) {
            if (err || !foundRestaurant) {
                req.flash("error", "Restaurant Listing not found.");
                res.redirect("back");
            } else {
                // check if req.user._id exists in foundCampground.reviews
                var foundUserReview = foundRestaurant.reviews.some(function (review) {
                    return review.author.id.equals(req.user._id);
                });
                if (foundUserReview) {
                    req.flash("error", "You already wrote a review.");
                    return res.redirect("/restaurantss/" + foundRestaurant._id);
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

middlewareObj.checkProfileOwnership = function(req, res, next) {
  User.findById(req.params.user_id, function(err, foundUser) {
    if (err || !foundUser) {
      req.flash("error", "Sorry, that user doesn't exist");
      res.redirect("/restaurants");
    } else if (foundUser._id.equals(req.user._id) || req.user.isAdmin) {
      req.user = foundUser;
      next();
    } else {
      req.flash("error", "You don't have permission to do that!");
      res.redirect("/restaurants/" + req.params.id);
    }
  });
};

//middleware exports router
module.exports = middlewareObj;