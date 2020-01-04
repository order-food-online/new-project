var mongoose = require("mongoose");
var Review = require("./review");
//SCHEMA SETUP DATABASE MODEL.
var restaurantSchema = new mongoose.Schema({
	restaurant_name: String,
	image: {
		id: String,
		url: String
	},
	restaurant_telephone: String,
	restaurant_address: String,
	price: String,
	description: String,
	cuisine_type: String,
	cuisine_type1: String,
	cuisine_type2: String,
	cuisine_type3: String,
	cuisine_tags: String,
	cuisine_tag1: String,
	cuisine_tag2: String,
	cuisine_tag3: String,
	cuisine_tag4: String,
	monday_hours: String,
	monday_hours_closed: String,
	monday_from_hours: String,
	monday_to_hours: String,
	tuesday_hours: String,
	tuesday_hours_closed: String,
	tuesday_from_hours: String,
	tuesday_to_hours: String,
	wednesday_hours: String,
	wednesday_hours_closed: String,
	wednesday_from_hours: String,
	wednesday_to_hours: String,
	thursday_hours: String,
	thursday_hours_closed: String,
	thursday_from_hours: String,
	thursday_to_hours: String,
	friday_hours: String,
	friday_hours_closed: String,
	friday_from_hours: String,
	friday_to_hours: String,
	saturday_hours: String,
	saturday_hours_closed: String,
	saturday_from_hours: String,
	saturday_to_hours: String,
	sunday_hours: String,
	sunday_hours_closed: String,
	sunday_from_hours: String,
	sunday_to_hours: String,
	restaurant_services: String,
	restaurant_services1: String,
	restaurant_services2: String,
	restaurant_services3: String,
	restaurant_services4: String,
	restaurant_website: String,
	payment_methods: String,
	opening_status: String,
	restaurant_owner: String,
	serves_alcohol: String,
	location: String,
	restaurant_postal_code: String,
	lat: Number,
	lng: Number,
	createdAt: { type: Date, default: Date.now },
	author: {
		id: {
			type: mongoose.Schema.Types.ObjectId,
			ref: "User"
		},
		username: String
	},
	comments: [
		{
			type: mongoose.Schema.Types.ObjectId,
			ref: "Comments"
		}
	],
	likes: [
		{
			type: mongoose.Schema.Types.ObjectId,
			ref: "User"
		}
	],
	reviews: [
		{
			type: mongoose.Schema.Types.ObjectId,
			ref: "Review"
		}
	],
	rating: {
		type: Number,
		default: 0
	}
});

//SCHEMA MODE ORIENTATION
module.exports = mongoose.model("Restaurant", restaurantSchema);