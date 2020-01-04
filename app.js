//intalled packages
var express 				= require("express");
var	app 					= express();
var bodyParser 				= require("body-parser");
var mongoose 				= require("mongoose");
var flash                   = require("connect-flash");
var passport 				= require("passport");
var LocalStrategy 			= require("passport-local");
var methodOverride          = require("method-override");
var Restaurant				= require("./models/restaurant");
var Comment 				= require("./models/comment");
var User 					= require("./models/user");
var seedDB 					= require("./seeds");
var commentRoutes 			= require("./routes/comments");
var restaurantRoutes 		= require("./routes/restaurant");
var indexRoutes 			= require("./routes/index");
var reviewRoutes			= require("./routes/reviews");
var sphp					= require("sphp");

app.locals.moment = require("moment");
//mongo altas
mongoose.connect('mongodb+srv://joejoe11:joejoe11@cluster0-ablik.mongodb.net/testretryWrites=true', {
	useNewUrlParser: true,
	useCreateIndex: true
}).then(() => {
	console.log('Connected to DB');
}).catch(err => {
	console.log('ERROR', err.message);
});


// Load a plugin.
//code for connecting data part 1
//var url = process.env.DATABASEURL || "mongodb://localhost/yelp_camp_v10";
//mongoose.connect(url, {useNewUrlParser: true});
//part 1
//orignal code
//mongoose.connect("mongodb://localhost:27017/have_lots_v1", {useNewUrlParser: true});
app.use(bodyParser.urlencoded({extended: true}));
app.set("view engine", "ejs");
app.use(express.static(__dirname  + "/public"));
//php files
app.use(sphp.express("public/"));
app.use(methodOverride("_method"));
app.use(flash());
// seedDB(); //seed the database

// PASSPORT CONFIGURATION
app.use(require("express-session")({
	secret: "THIS IS A TEST LOGIN!",
	resave: false,
	saveUninitialized: false
}));
app.use(passport.initialize());
app.use(passport.session());
passport.use(new LocalStrategy(User.authenticate()));
passport.serializeUser(User.serializeUser());
passport.deserializeUser(User.deserializeUser());
						 
app.use(function(req, res, next){
	res.locals.currentUser = req.user;
	res.locals.error = req.flash("error");
	res.locals.success = req.flash("success");
	next();
});
// requiring routes
app.use("/", indexRoutes);
app.use("/restaurants", restaurantRoutes);
app.use("/restaurants/:id/comments", commentRoutes);
app.use("/restaurants/:id/reviews", reviewRoutes);

//server connection for server
//app.listen(8080, () => {
//	console.log("Have Lots Need Lots Has Started the Server");
//});
app.listen(process.env.PORT, process.env.IP, function(){
   console.log("Order Food Online Server Has Started!");
});
