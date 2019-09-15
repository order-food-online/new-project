var express = require("express");
var router = express.Router();
var Campground = require("../models/campground");
var middleware = require("../middleware");
var NodeGeocoder = require("node-geocoder");
var Review = require("../models/review");
var Comment = require("../models/comment");
var multer = require("multer");
var cloudinary = require("cloudinary");
 
var options = {
  provider: "google",
  httpAdapter: "https",
  apiKey: "AIzaSyAe1yAyaNzM1pyf5R2gL4ET-C8retgt1JY",
  formatter: null
};
 
var geocoder = NodeGeocoder(options);

// ============ Image upload ============
var storage = multer.diskStorage({
  filename: function (req, file, cb) {
    cb(null, Date.now() + file.originalname);
  }
});
var imageFilter = function (req, file, cb) {
  // accept image files only
  if (!file.originalname.match(/\.(jpg|jpeg|png|gif)$/i)) {
    return cb(new Error('Only image files are allowed!'), false);
  }
  cb(null, true);
};
var upload = multer({ storage: storage, fileFilter: imageFilter });

cloudinary.config({
  cloud_name: "jmspos",
  api_key: "755834234492745",
  api_secret: "P7GJcVWlVYVLKgprCTsUxhRJqTE"
});


//======================================================================

//FUSSY SEARCH BAR FEATURE

//======================================================================

// Regex sanitizer function
const escapeRegex = text => text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');

// Index
router.get('/', (req, res) => {
  // search was used
  if (req.query.search) {
    let regex = new RegExp(escapeRegex(req.query.search), 'gi');
    Campground.find({name: regex}, (err, campgrounds) => {
      if (err || !campgrounds) {
        req.flash('error', 'There was a problem with the search.');
      }
      // if no results found, send a message to display in the view
      let message = 'Couldn\'t find a matching campround name.';
      campgrounds.length === 0
        ? res.render('campgrounds/index', {campgrounds: campgrounds, currentPage: 'campgrounds', searchMessage: message})
        : res.render('campgrounds/index', {campgrounds: campgrounds, currentPage: 'campgrounds'});
    });
  } else {
  // get all campgrounds from DB
    Campground.find({}, (err, campgrounds) => {
      if (err) {
        throw err;
      } else {
        res.render('campgrounds/index', {campgrounds: campgrounds, currentPage: 'campgrounds'});
      }
    });
  }
});


//======================================================================

//INDEX - SHOWS ALL CAMPGROUNDS
//route app campground page

//======================================================================
router.get("/", function(req, res){
	//get all campgrounds from DB
	Campground.find({}, function(err, allCampgrounds){
		if(err){
			console.log(err);
		} else {
			res.render("campgrounds/index", {campgrounds: allCampgrounds, page: "campgrounds"});
		}
	});
});

//=====================================================================

//CREATE - ADD NEW CAMGROUND to DATABASE
//posting new campground function

//=====================================================================

router.post("/", middleware.isLoggedIn, upload.single("imageLocal"), function(req, res){
	//get data from form and add to campgrounds array
	var name = req.body.name;
	var age = req.body.age;
	var type_items = req.body.type_items;
	var gender = req.body.gender;
	var postal_code = req.body.postal_code;
	var image;
	var description = req.body.description;
	var author = {
		id: req.user._id,
		username: req.user.username
	};
	//geocoding code starts/modified
	geocoder.geocode(req.body.location, function (err, data){
    if (err || !data.length) {
      req.flash("error", "Invalid address");
      return res.redirect("back");
    }
    var lat = data[0].latitude;
    var lng = data[0].longitude;
    var location = data[0].formattedAddress;
    //if cloudinary
    //cloudinary
    if (req.file) {
      cloudinary.v2.uploader.upload(req.file.path, { transformation: [
        { width: 2048 }]}, (err, result) => {
        if (err) {
          req.flash("error", err.message);
          return res.redirect("back");
        }
        // add cloudinary image props
        image = {
          id: result.public_id,
          url: result.secure_url
        }
        //cloudinary ends
         Campground.create({name, age, type_items, gender, postal_code, image, description, location, lat, lng, author}, (err, campground) => {
          if (err) {
            req.flash("error", "Couldn\'t add campground.");
          } else {
            req.flash("success", "Campground added successfully.");
          }
          res.redirect("/campgrounds");
        });
      });
    } else { (console.log("no file to upload!!")); }
  });
});
   //geocoding code added /ends
	//var newCampgrounds = {name: name, price: price, image: image,
	//					  description: description, author: author, location: location, lat: lat,lng: lng};
	// Create a new campground and save to DB
	//Campground.create(newCampgrounds, function(err, newlyCreated){
	//	if(err){
	//		console.log(err);
	//	} else {
	//		//redirect back to campgrounds page
	//		console.log(newlyCreated);
	//		res.redirect("/campgrounds");	
	//	}
	//});
 // });
//});

		

//=====================================================================

//NEW - SHOW form to create new campground

//=====================================================================

router.get("/new", middleware.isLoggedIn, function(req, res){
	res.render("campgrounds/new");	
});

//SHOW - shows more info about one campground
router.get("/:id", function(req, res){
	//find the campground with provided ID/addred reviews populate function
	Campground.findById(req.params.id).populate("comments").populate("likes").populate({
		path: "reviews",
		options: {sort: {createdAt: -1}}
	}).exec(function(err, foundCampground){
		if(err || !foundCampground){
			req.flash("error", "Campground not Found!");
			res.redirect("back");
		} else {
			console.log(foundCampground);
			//render show template with that campground
			res.render("campgrounds/show", {campgrounds: foundCampground});
		}
	});
});

//=======================================================================

//EDIT CAMPGROUND ROUTE

//=======================================================================

router.get("/:id/edit", middleware.checkCampgroundOwnership, function(req, res){
		Campground.findById(req.params.id, function(err, foundCampground){
					res.render("campgrounds/edit", {campground: foundCampground});
		});
});

//========================================================================

//UPDATE CAMPGROUND ROUTE

//========================================================================
//router.put("/:id", middleware.checkCampgroundOwnership, function(req, res){
	// find and update the correct campground
//	Campground.findByIdAndUpdate(req.params.id, req.body.campground, function(err, updatedCampground){
//		if(err){
//			res.redirect("/campgrounds");
//		}else {
//			// redirect somwhere (show page)
//			res.redirect("/campgrounds/" + req.params.id);
//		}
//	});
//});
//new code below google maps if bugs remove
router.put("/:id", middleware.checkCampgroundOwnership, upload.single("imageLocal"), function(req, res){
    geocoder.geocode(req.body.location, (err, data) => {
    if (err || data.length === 0) {
      req.flash('error', 'Invalid location');
      return res.redirect("/campgrounds/" + req.params.id + "/edit");
    }
    let updateData = {
      name: req.body.name,
      age: req.body.age,
      gender: req.body.gender,
      types_items: req.body.types_items,
      postal_code: req.body.postal_code,
      description: req.body.description,
      location: data[0].formattedAddress,
      lat: data[0].latitude,
      lng: data[0].longitude
    };
    // new file update, upload to cloudinary and delete old one
    if (req.file) {
      cloudinary.v2.uploader.upload(req.file.path, {transformation: [{ width: 2048 }]}, (err, result) => {
        if (err) {
          req.flash('error', err.message);
          return res.redirect('back');
        }
        // update cloudinary image props
        updateData.image = {
          id: result.public_id,
          url: result.secure_url
        }
        // delete old picture
        //cloudinary.v2.uploader.destroy(req.campgrounds.image.id, (err, result) => console.log(result));
        // save campground
        Campground.findByIdAndUpdate(req.params.id, {$set: updateData}, (err, campground) => {
          if (err) {
            req.flash('error', 'Couldn\'t update campground.');
          } else {
            req.flash('success', 'Campground updated successfully.');
          }
          res.redirect("/campgrounds/" + campground._id); // or req.params.id
        });
      });// cloudinary
    } else { // no new file to upload
      // save campground
      Campground.findByIdAndUpdate(req.params.id, {$set: updateData}, (err, campground) => {
        if (err) {
          req.flash('error', 'Couldn\'t update campground.');
        } else {
          req.flash('success', 'Campground updated successfully.');
        }
        res.redirect("/campgrounds/" + campground._id); // or req.params.id
      });
    } 
  });// geocoder
});
  //geocoder.geocode(req.body.location, function (err, data) {
    //if (err || !data.length) {
      //req.flash('error', 'Invalid address');
      //return res.redirect('back');
    //}
    //req.body.campground.lat = data[0].latitude;
    //req.body.campground.lng = data[0].longitude;
    //req.body.campground.location = data[0].formattedAddress;

    //Campground.findByIdAndUpdate(req.params.id, req.body.campground, function(err, campground){
        //if(err){
            //req.flash("error", err.message);
            //res.redirect("back");
        //} else {
            //req.flash("success","Successfully Updated!");
            //res.redirect("/campgrounds/" + campground._id);
        //}
    //});
  //});
//});


//========================================================================

//Campground Like Route

//========================================================================
// Campground Like Route Starts
router.post("/:id/like", middleware.isLoggedIn, function (req, res) {
    Campground.findById(req.params.id, function (err, foundCampground) {
        if (err) {
            console.log(err);
            return res.redirect("/campgrounds");
        }

        // check if req.user._id exists in foundCampground.likes
        var foundUserLike = foundCampground.likes.some(function (like) {
            return like.equals(req.user._id);
        });

        if (foundUserLike) {
            // user already liked, removing like
            foundCampground.likes.pull(req.user._id);
        } else {
            // adding the new user like
            foundCampground.likes.push(req.user._id);
        }

        foundCampground.save(function (err) {
            if (err) {
                console.log(err);
                return res.redirect("/campgrounds");
            }
            return res.redirect("/campgrounds/" + foundCampground._id);
        });
    });
});
// Like Route Ends

//========================================================================

//DESTROY CAMPGROUND ROUTE

//========================================================================
//new code if doesn't work remove add this back
//router.delete("/:id", middleware.checkCampgroundOwnership, function(req, res){
//	Campground.findByIdAndRemove(req.params.id, function(err){
//		if(err){
//			res.redirect("/campgrounds");
//		}else {
//			res.redirect("/campgrounds");
//		}
//	});
//});
router.delete("/:id", middleware.checkCampgroundOwnership, function (req, res) {
    Campground.findById(req.params.id, function (err, campground) {
        if (err) {
            res.redirect("/campgrounds");
        } else {
            // deletes all comments associated with the campground
            Comment.remove({"_id": {$in: campground.comments}}, function (err) {
                if (err) {
                    console.log(err);
                    return res.redirect("/campgrounds");
                }
                // deletes all reviews associated with the campground
                Review.remove({"_id": {$in: campground.reviews}}, function (err) {
                    if (err) {
                        console.log(err);
                        return res.redirect("/campgrounds");
                    }
                    //  delete the campground
                    campground.remove();
                    req.flash("success", "Campground deleted successfully!");
                    res.redirect("/campgrounds");
                });
            });
        }
    });
});


//exports code for router exports
module.exports = router;