// this controller will be requested when the order is confirmed
// this controller will be requested by the admin or the user

// validate the input (add necessary functions in the Validator Class then use it here)
// require the same view and show error msgs if something is wrong

// verify the order is feasible (verify if it doesn't violate the database)
// require the same view and show error msgs if something is wrong

// authentice the user (compare session id with request user id (IF session role is set to customer))
// authentice the user (compare session id with request user id (IF session role is set to admin))
// redirect to orders/index.php and pass the needed varaibles for the latest order section
// die