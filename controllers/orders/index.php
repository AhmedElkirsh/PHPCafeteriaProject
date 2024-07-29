// screen 3 in project pdf, pass the needed variables as an assoc array in the second argument of the view function
// as an example 

/imagine if this was a logic to fetch the link to the user's picture and store it in $pic/
[
    'pic' => $pic,
    'heading' => 'Welcome, {$_SESSION['name']}',
    ...
]

when u use the view function, the new file will have the variables that u defined in the array
so if you use $pic or $heading, they will hold the values u passed

// this controller is the what the user will be redirected to when he/she logins 

// this controller will also be requested when the user changes the date filter and click a button
