var express = require("express");
var router = express.Router({mergeParams: true});
var Restaurant = require("../models/restaurant");
var Comment = require("../models/comment");
var middleware = require("../middleware");

//===============================================================

//Comments new

//===============================================================
router.get("/new", middleware.isLoggedIn, function(req, res){
	//find restaurant listing by id
	Restaurant.findById(req.params.id, function(err, restaurant){
		if(err){
			console.log(err);
		}else {
			res.render("comments/new", {restaurant: restaurant});
		}
	});
});

//===============================================================

//Comments Create

//===============================================================
router.post("/", middleware.isLoggedIn, function(req, res){
	//lookup restaurant listing using ID
	Restaurant.findById(req.params.id, function(err, restaurant){
		if(err){
			console.log(err);
			res.redirect("/restaurants");
		} else {
			//create new comments
			Comment.create(req.body.comment, function(err, comment){
				if(err){
					req.flash("error", "Something went wrong");
					console.log(err);
				} else {
			//connect new comment to restaurant listing
			//redirect restaurant listing show page
					
					//add username and id to comment
					comment.author.id = req.user._id;
					comment.author.username = req.user.username;
					//save comment
					comment.save();
					restaurant.comments.push(comment);
					restaurant.save();
					req.flash("success", "Sucessfully added Comment!");
					res.redirect('/restaurants/' + restaurant._id);
				}
			});
		}
	});
});

//===============================================================

//COMMENTS EDIT ROUTE

//===============================================================

router.get("/:comment_id/edit", middleware.checkCommentOwnership, function(req, res){
	Restaurant.findById(req.params.id, function(err, foundRestaurant){
		if(err || !foundRestaurant){
			req.flash("error", "Cannont Find that Restaurant Listing!");
			return res.redirect("back");
		}
		Comment.findById(req.params.comment_id, function(err, foundComment){
			if(err){
				res.redirect("back");
			}else {
				res.render("comments/edit", {restaurant_id: req.params.id, comment: foundComment});
			}
		});
	});

});

//===============================================================

//COMMENTS UPDATE ROUTE

//===============================================================

router.put("/:comment_id", middleware.checkCommentOwnership, function(req, res){
	Comment.findByIdAndUpdate(req.params.comment_id, req.body.comment, function(err, updatedComment){
		if(err){
			res.redirect("back");
		}else {
			res.redirect("/restaurants/" + req.params.id );
		}
	});
});


//===============================================================

//COMMENTS DESTROY/DELETE ROUTE

//===============================================================

router.delete("/:comment_id", middleware.checkCommentOwnership, function(req, res){
	//findByIdAndRemove
	Comment.findByIdAndRemove(req.params.comment_id, function(err, ){
		if(err){
			res.redirect("back");
		} else {
			req.flash("success", "Comment Deleted!");
			res.redirect("/restaurants/" + req.params.id);
		}
	});
});


module.exports = router;
