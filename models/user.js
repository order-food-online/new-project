var mongoose = require("mongoose");
var passportLocalMongoose = require("passport-local-mongoose");

var UserSchema = new mongoose.Schema({
	username: String,
	password: String,
	image: String,
	imageId: String,
	firstName: String,
	phone: String,
	lastName: String,
	email: String,
	joined: { type: Date, default: Date.now },
	isAdmin: {type: Boolean, default: false}
});

UserSchema.plugin(passportLocalMongoose);

module.exports = mongoose.model("User", UserSchema);