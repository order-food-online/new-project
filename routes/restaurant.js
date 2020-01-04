var express = require("express");
var router = express.Router();
var Restaurant = require("../models/restaurant");
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

//SEARCH BAR FUNCTIONILITY

//======================================================================

// Regex sanitizer function
const escapeRegex = text => text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');

// Index
router.get('/', (req, res) => {
  // search was used
  if (req.query.search) {
    let regex = new RegExp(escapeRegex(req.query.search), 'gi');
    Restaurant.find({location: regex}, (err, restaurants) => {
      if (err || !restaurants) {
        req.flash('error', 'There was a problem with the search.');
      }
      // if no results found, send a message to display in the view
      let message = 'Couldn\'t find a matching restaurant name.';
      restaurants.length === 0
        ? res.render('restaurants/index', {restaurants: restaurants, currentPage: 'restaurants', searchMessage: message})
        : res.render('restaurants/index', {restaurants: restaurants, currentPage: 'restaurants'});
    });
  } else {
  // get all restaurants listings from DB
    Restaurant.find({}, (err, restaurants) => {
      if (err) {
        throw err;
      } else {
        res.render('restaurants/index', {restaurants: restaurants, currentPage: 'restaurants',});
      }
    });
  }
});

//======================================================================

// INDEX - SHOWS ALL Restaurant LISTINGS
// route app restaurant Listing page

//======================================================================

router.get("/", function(req, res){
	// get all restaurants listings from DB
	Restaurant.find({}, function(err, allRestaurants){
		if(err){
			console.log(err);
		} else {
			res.render("restaurants/index", {restaurants: allRestaurants, page: "restaurants"});
		}
	});
});

//=====================================================================

// CREATE - ADD NEW restaurants to DATABASE
// posting new restaurants Listing function

//=====================================================================

router.post("/", middleware.isLoggedIn, upload.single("imageLocal"), function(req, res){
	// get data from form and add to restaurants listing array
	var restaurant_name = req.body.restaurant_name;
	var restaurant_telephone = req.body.restaurant_telephone;
	var restaurant_address = req.body.restaurant_address;
	var price = req.body.price;
	var cuisine_type = req.body.cuisine_type;
	var cuisine_type1 = req.body.cuisine_type1;
	var cuisine_type2 = req.body.cuisine_type2;
	var cuisine_type3 = req.body.cuisine_type3;
	var cuisine_tags = req.body.cuisine_tags;
	var cuisine_tag1 = req.body.cuisine_tag1;
	var cuisine_tag2 = req.body.cuisine_tag2;
	var cuisine_tag3 = req.body.cuisine_tag3;
	var cuisine_tag4 = req.body.cuisine_tag4;
	//ai chat features for form
	//end ai chat feature for form
	//hours variables
	var monday_hours = req.body.monday_hours;
	var monday_hours_closed = req.body.monday_hours_closed;
	var monday_from_hours = req.body.monday_from_hours;
	var monday_to_hours = req.body.monday_to_hours;
	var tuesday_hours = req.body.tuesday_hours;
	var tuesday_hours_closed = req.body.tuesday_hours_closed;
	var tuesday_from_hours = req.body.tuesday_from_hours;
	var tuesday_to_hours = req.body.tuesday_to_hours;
	var wednesday_hours = req.body.wednesday_hours;
	var wednesday_hours_closed = req.body.wednesday_hours_closed;
	var wednesday_from_hours = req.body.wednesday_from_hours;
	var wednesday_to_hours = req.body.wednesday_to_hours;
	var thursday_hours = req.body.thursday_hours;
	var thursday_hours_closed = req.body.thursday_hours_closed;
	var thursday_from_hours = req.body.thursday_from_hours;
	var thursday_to_hours = req.body.thursday_to_hours;
	var friday_hours = req.body.friday_hours;
	var friday_hours_closed = req.body.friday_hours_closed;
	var friday_from_hours = req.body.friday_from_hours;
	var friday_to_hours = req.body.friday_to_hours;
	var saturday_hours = req.body.saturday_hours;
	var saturday_hours_closed = req.body.saturday_hours_closed;
	var saturday_from_hours = req.body.saturday_from_hours;
	var saturday_to_hours = req.body.saturday_to_hours;
	var sunday_hours = req.body.sunday_hours;
	var sunday_hours_closed = req.body.sunday_hours_closed;
	var sunday_from_hours = req.body.sunday_from_hours;
	var sunday_to_hours = req.body.sunday_to_hours;
	//end hours variables
	var restaurant_services = req.body.restaurant_services;
	var restaurant_services1 = req.body.restaurant_services1;
	var restaurant_services2 = req.body.restaurant_services2;
	var restaurant_services3 = req.body.restaurant_services3;
	var restaurant_services4 = req.body.restaurant_services4;
	var restaurant_website = req.body.restaurant_website;
	var payment_methods = req.body.payment_methods;
	var restaurant_postal_code = req.body.restaurant_postal_code;
	var opening_status = req.body.opening_status;
	var restaurant_owner = req.body.restaurant_owner;
	var serves_alcohol = req.body.serves_alcohol;
	var image;
	var description = req.body.description;
	var author = {
		id: req.user._id,
		username: req.user.username
	};
	// geocoding code starts/modified
	geocoder.geocode(req.body.location, function (err, data){
    if (err || !data.length) {
      req.flash("error", "Invalid address");
      return res.redirect("back");
    }
    var lat = data[0].latitude;
    var lng = data[0].longitude;
    var location = data[0].formattedAddress;
    // if cloudinary
    // cloudinary
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
        // cloudinary ends
        Restaurant.create({
            restaurant_name, 
            restaurant_telephone, 
            restaurant_address,
            price,
            cuisine_type,
            cuisine_type1,
            cuisine_type2,
            cuisine_type3,
            cuisine_tags,
            cuisine_tag1,
            cuisine_tag2,
            cuisine_tag3,
            cuisine_tag4,
            //ai chat features for form
            //end ai chat features for form
            //hours variables
            monday_hours,
            monday_hours_closed,
            monday_from_hours,
            monday_to_hours,
            tuesday_hours,
            tuesday_hours_closed,
            tuesday_from_hours,
            tuesday_to_hours,
            wednesday_hours,
            wednesday_hours_closed,
            wednesday_from_hours,
            wednesday_to_hours,
            thursday_hours,
            thursday_hours_closed,
            thursday_from_hours,
            thursday_to_hours,
            friday_hours,
            friday_hours_closed,
            friday_from_hours,
            friday_to_hours,
            saturday_hours,
            saturday_hours_closed,
            saturday_from_hours,
            saturday_to_hours,
            sunday_hours,
            sunday_hours_closed,
            sunday_from_hours,
            sunday_to_hours,
            //end hours variables
            restaurant_services,
            restaurant_services1,
            restaurant_services2,
            restaurant_services3,
            restaurant_services4,
            restaurant_website,
            payment_methods,
            restaurant_postal_code, 
            opening_status, 
            restaurant_owner, 
            serves_alcohol, 
            image, 
            description, 
            location, 
            lat, 
            lng, 
            author}, (err, restaurant) => {
          if (err) {
            req.flash("error", "Couldn\'t add Restaurant Listing.");
          } else {
            req.flash("success", "Restaurant Listing added successfully.");
          }
          res.redirect("/restaurants");
        });
      });
    } else { (console.log("no file to upload!!")); }
  });
});
  // geocoding code added /ends
	// var newCampgrounds = {name: name, price: price, image: image,
	// description: description, author: author, location: location, lat: lat,lng: lng};
	// Create a new campground and save to DB
	// Campground.create(newCampgrounds, function(err, newlyCreated){
	//  if(err){
	//    console.log(err);
	//  } else {
	//		//redirect back to campgrounds page
	//		console.log (newlyCreated);
	//		res.redirect ("/campgrounds");	
	//	}
	//  });
 // });
//});
//  new form add menu

		

//=====================================================================

//NEW - SHOW form to create new restaurants

//=====================================================================

router.get("/new", middleware.isLoggedIn, function(req, res){
	res.render("restaurants/new");	
});

//=====================================================================

//SHOW - shows more info about one restaurants

//=====================================================================

router.get("/:id", function(req, res){
	// find the restaurant listing with provided ID/addred reviews populate function
	Restaurant.findById(req.params.id).populate("comments").populate("likes").populate({
		path: "reviews",
		options: {sort: {createdAt: -1}}
	}).exec(function(err, foundRestaurant){
		if(err || !foundRestaurant){
			req.flash("error", "Restaurant not Found!");
			res.redirect("back");
		} else {
			console.log(foundRestaurant);
			// render show template with that restaurants Listing
			res.render("restaurants/show", {restaurants: foundRestaurant});
		}
	});
});

//=======================================================================

//EDIT RESTAURANTS ROUTE

//=======================================================================

router.get("/:id/edit", middleware.checkRestaurantOwnership, function(req, res){
		Restaurant.findById(req.params.id, function(err, foundRestaurant){
		  res.render("restaurants/edit", {restaurant: foundRestaurant});
		});
});

//========================================================================

//UPDATE RESTAURANT ROUTE

//========================================================================
// router.put("/:id", middleware.checkCampgroundOwnership, function(req, res){
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
// new code below google maps if bugs remove

router.put("/:id", middleware.checkRestaurantOwnership, upload.single("imageLocal"), function(req, res){
    geocoder.geocode(req.body.location, (err, data) => {
    if (err || data.length === 0) {
      req.flash('error', 'Invalid location');
      return res.redirect("/restaurants/" + req.params.id + "/edit");
    }
    let updateData = {
      restaurant_name: req.body.restaurant_name,
      restaurant_telephone: req.body.restaurant_telephone,
      price: req.body.price,
      cuisine_type: req.body.cuisine_type,
      cuisine_type1: req.body.cuisine_type1,
      cuisine_type2: req.body.cuisine_type2,
      cuisine_type3: req.body.cuisine_type3,
      cuisine_tags: req.body.cuisine_tags,
      cuisine_tag1: req.body.cuisine_tag1,
      cuisine_tag2: req.body.cuisine_tag2,
      cuisine_tag3: req.body.cuisine_tag3,
      cuisine_tag4: req.body.cuisine_tag4,
      monday_hours: req.body.monday_hours,
      monday_hours_closed: req.body.monday_hours_closed,
      monday_from_hours: req.body.monday_from_hours,
      monday_to_hours: req.body.monday_to_hours,
      tueday_hours: req.body.tuesday_hours,
      tuesday_hours_closed: req.body.tuesday_hours_closed,
      tuesday_from_hours: req.body.tuesday_from_hours,
      tuesday_to_hours: req.body.tuesday_to_hours,
      wednesday_hours: req.body.wednesday_hours,
      wednesday_hours_closed: req.body.wednesday_hours_closed,
      wednesday_from_hours: req.body.wednesday_from_hours,
      wednesday_to_hours: req.body.wednesday_to_hours,
      thursday_hours: req.body.thursday_hours,
      thursday_hours_closed: req.body.thursday_hours_closed,
      thursday_from_hours: req.body.thursday_from_hours,
      thursday_to_hours: req.body.thursday_to_hours,
      friday_hours: req.body.friday_hours,
      friday_hours_closed: req.body.friday_hours_closed,
      friday_from_hours: req.body.friday_from_hours,
      friday_to_hours: req.body.friday_to_hours,
      saturday_hours: req.body.saturday_hours,
      saturday_hours_closed: req.body.saturday_hours_closed,
      saturday_from_hours: req.body.saturday_from_hours,
      saturday_to_hours: req.body.saturday_to_hours,
      sunday_hours: req.body.sunday_hours,
      sunday_hours_closed: req.body.sunday_hours_closed,
      sunday_from_hours: req.body.sunday_from_hours,
      sunday_to_hours: req.body.sunday_to_hours,
      restaurant_services: req.body.restaurant_services,
      restaurant_services1: req.body.restaurant_services1,
      restaurant_services2: req.body.restaurant_services2,
      restaurant_services3: req.body.restaurant_services3,
      restaurant_services4: req.body.restaurant_services4,
      restaurant_website: req.body.restaurant_website,
      payment_methods: req.body.payment_methods,
      restaurant_address: req.body.restaurant_address,
      restaurant_postal_code: req.body.restaurant_postal_code,
      opening_status: req.body.opening_status,
      restaurant_owner: req.body.restaurant_owner,
      serves_alcohol: req.body.serves_alcohol,
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
        // cloudinary.v2.uploader.destroy(req.lots.image.id, (err, result) => console.log(result));
        // save campground
        Restaurant.findByIdAndUpdate(req.params.id, {$set: updateData}, (err, restaurant) => {
          if (err) {
            req.flash('error', 'Couldn\'t update Restaurant Listing.');
          } else {
            req.flash('success', 'Restaurant Listing updated successfully.');
          }
          res.redirect("/restaurants/" + restaurant._id); // or req.params.id
        });
      });// cloudinary
    } else { // no new file to upload
      // save lot listing
      Restaurant.findByIdAndUpdate(req.params.id, {$set: updateData}, (err, restaurant) => {
        if (err) {
          req.flash('error', 'Couldn\'t update Restaurant Listing.');
        } else {
          req.flash('success', 'Restaurant Listing updated successfully.');
        }
        res.redirect("/restaurants/" + restaurant._id); // or req.params.id
      });
    } 
  });// geocoder
});

  // geocoder.geocode(req.body.location, function (err, data) {
    // if (err || !data.length) {
      // req.flash('error', 'Invalid address');
      // return res.redirect('back');
    //}
    // req.body.campground.lat = data[0].latitude;
    // req.body.campground.lng = data[0].longitude;
    // req.body.campground.location = data[0].formattedAddress;

    // Campground.findByIdAndUpdate(req.params.id, req.body.campground, function(err, campground){
        //if(err){
            // req.flash("error", err.message);
            // res.redirect("back");
        //} else {
            // req.flash("success","Successfully Updated!");
            // res.redirect("/campgrounds/" + campground._id);
        //}
    //});
  //});
//});


//========================================================================

//Restaurant Listings Like Route

//========================================================================

// Restaurant Like Route Starts

router.post("/:id/like", middleware.isLoggedIn, function (req, res) {
    Restaurant.findById(req.params.id, function (err, foundRestaurant) {
        if (err) {
            console.log(err);
            return res.redirect("/restaurants");
        }

        // check if req.user._id exists in foundLot.likes
        var foundUserLike = foundRestaurant.likes.some(function (like) {
            return like.equals(req.user._id);
        });

        if (foundUserLike) {
            // user already liked, removing like
            foundRestaurant.likes.pull(req.user._id);
        } else {
            // adding the new user like
            foundRestaurant.likes.push(req.user._id);
        }

        foundRestaurant.save(function (err) {
            if (err) {
                console.log(err);
                return res.redirect("/restaurants");
            }
            return res.redirect("/restaurants/" + foundRestaurant._id);
        });
    });
});
// Like Route Ends

//========================================================================

//DESTROY Restaurant Listing ROUTE

//========================================================================
// new code if doesn't work remove add this back
// router.delete("/:id", middleware.checkCampgroundOwnership, function(req, res){
//	Campground.findByIdAndRemove(req.params.id, function(err){
//		if(err){
//			res.redirect("/campgrounds");
//		}else {
//			res.redirect("/campgrounds");
//		}
//	});
//});

router.delete("/:id", middleware.checkRestaurantOwnership, function (req, res) {
    Restaurant.findById(req.params.id, function (err, restaurant) {
        if (err) {
            res.redirect("/restaurants");
        } else {
            // deletes all comments associated with the lots listings
            Comment.remove({"_id": {$in: restaurant.comments}}, function (err) {
                if (err) {
                    console.log(err);
                    return res.redirect("/restaurants");
                }
                // deletes all reviews associated with the lot listings
                Review.remove({"_id": {$in: restaurant.reviews}}, function (err) {
                    if (err) {
                        console.log(err);
                        return res.redirect("/restaurants");
                    }
                    //  delete the restaurant review
                    restaurant.remove();
                    req.flash("success", "Restaurant Review deleted successfully!");
                    res.redirect("/restaurants");
                });
            });
        }
    });
});


// exports code for router exports
module.exports = router;