// view screen 1 in pdf, pass the needed variables as an assoc array in the second argument of the view function
// as an example 

/imagine if this was a logic to fetch the link to the user's picture and store it in $pic/
[
    'pic' => $pic,
    'heading' => 'Welcome, {$_SESSION['name']}',
    ...
]

when u use the view function, the new file will have the variables that u defined in the array
so if you use $pic or $heading, they will hold the values u passed

// note that will be an if statement in the corresponding view (to eather display the users search bar [admin] or latest order [customer])

