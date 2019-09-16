var express = require("express");
var router = express.Router({mergeParams: true});
var Lot = require("../models/lot");
var Comment = require("../models/comment");
var middleware = require("../middleware");

//===============================================================

//Comments new

//===============================================================
router.get("/new", middleware.isLoggedIn, function(req, res){
	//find lot listing by id
	Lot.findById(req.params.id, function(err, lot){
		if(err){
			console.log(err);
		}else {
			res.render("comments/new", {lot: lot});
		}
	});
});

//===============================================================

//Comments Create

//===============================================================
router.post("/", middleware.isLoggedIn, function(req, res){
	//lookup lot listing using ID
	Lot.findById(req.params.id, function(err, lot){
		if(err){
			console.log(err);
			res.redirect("/lots");
		} else {
			//create new comments
			Comment.create(req.body.comment, function(err, comment){
				if(err){
					req.flash("error", "Something went wrong");
					console.log(err);
				} else {
			//connect new comment to lot listing
			//redirect lot listing show page
					
					//add username and id to comment
					comment.author.id = req.user._id;
					comment.author.username = req.user.username;
					//save comment
					comment.save();
					lot.comments.push(comment);
					lot.save();
					req.flash("success", "Sucessfully added Comment!");
					res.redirect('/lots/' + lot._id);
				}
			});
		}
	});
});

//===============================================================

//COMMENTS EDIT ROUTE

//===============================================================

router.get("/:comment_id/edit", middleware.checkCommentOwnership, function(req, res){
	Lot.findById(req.params.id, function(err, foundLot){
		if(err || !foundLot){
			req.flash("error", "Cannont Find that Lot Listing!");
			return res.redirect("back");
		}
		Comment.findById(req.params.comment_id, function(err, foundComment){
			if(err){
				res.redirect("back");
			}else {
				res.render("comments/edit", {lot_id: req.params.id, comment: foundComment});
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
			res.redirect("/lots/" + req.params.id );
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
			res.redirect("/lots/" + req.params.id);
		}
	});
});


module.exports = router;
