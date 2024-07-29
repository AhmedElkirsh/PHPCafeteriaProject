# PHPCafeteriaProject

## to use the database , follow the given instructions

### 1. make sure you are exporting the needed classes
```
use Core\App;
use Core\Database;
```
### 2. get the database using this line
```
$db = App::resolve(Database::class);
```
### 3. perform a query using the query method (u can chain find method or findOrfail) and store the result in a variable 
```
$note = $db->query("select * from notes where id=:id",['id'=>$_POST['id']])->find();
```

> [!NOTE]
> find method -> fetches 
> findOrFail -> fetches but aborts {redirects to 404 or other page} when there's no match in the database
> query -> prepares and executes the query

[^1]: check the Database.php class if you are still confused

## Request Types

There's 5 types of requests ,however, the `form` element only handles a `GET` or a `POST` method.

> [!NOTE]
> this section is mainly talking about how to handle requests in the "views". 
> u can check the `routes.php` file to see how the website will redirect those requests to the proper controller.
> each controller have a naming convention based on the action it handles, the next section talks about that.
> it was important to clarify the distinction to not cause confusion.

### GET
we will only use the GET method (in the routes.php file) for redirecting to a different controller, 
but never in forms as it causes security issues.
note that using href in the anchor tag is considered a get request
```
<a href="/">Go to Home Page</a>
```
the only scenario we could use the `$_GET` superglobal is when we use a "query string" to fetch different data, as an example:
**uri** : localhost/note?id=23
we will use the `$_GET` superglobal to get the value of the id, or change the value in the uri to show a different note

### POST 
any other method with the database will be through a `form` element with a method attribute set to POST
post requests are used, post requests are used when adding a record to a database. for example when registring or when adding a new order.
> [!CAUTION]
> don't forget to add the name attribute for each input.
```
<form action="/register" method="POST">
    <label for="email">
    <input id="email" type="email" name="email"/>
    <label for="password">
    <input id="password" type="password" name="email"/>
</form>
```
> [!NOTE]
> the Router class job is to redirect '/register' to the actual path of the controller handling the request.
> the mapping is done in the routes.php file, check the comments in that file.

### PATCH
as discussed eariler, we can't really set a method to a value of PATCH, so we use a workaround by setting the method of the form
to POST, then adding a hidden input to the form containing the method we really want, the logic that checks for the hidden input
is in `Public/index.php`, you don't need to do anything regarding that logic. here's an example of how to apply a patch request:
```
<form action="/notes" method="POST">
    <input type="hidden" name="_method" value="PATCH">
    <textarea>
        this is a note that will be edited.
    </textarea>
    <button type="submit">Update Note</button>
</form>
```

### DESTROY
similarly, the destroy request can be handled for example as follows 
```
<form action="/notes" method="POST">
    <input type="hidden" name="_method" value="DESTROY">
    <textarea>
        this is a note that will be deleted.
    </textarea>
    <button type="submit">Delete Note</button>
</form>
```
### DESTROY

this section will be updated in the future.

## Controller Files Overview

In the `controllers/[something]` folder, you will find several key files that handle different aspects of managing records in the database. Here’s a brief overview of each file and its purpose:

### `index.php`
- **Purpose**: Displays all records of a table (e.g., all orders).
- **Details**: Usually shows a list of records with headings and no detailed information.

### `create.php`
- **Purpose**: Provides the form or interface for creating a new record in the database (e.g., creating a new order).
- **Details**: Displays the fields and form elements necessary for adding a new record.

### `store.php`
- **Purpose**: Handles the insertion of a new record into the database (e.g., inserting a new order).
- **Details**: Processes the data submitted from `create.php` and adds it to the database.

### `show.php`
- **Purpose**: Shows the detailed information of a specific record (e.g., details of a specific order).
- **Details**: Typically used to display more in-depth information when a heading in `index.php` is clicked.

### `edit.php`
- **Purpose**: Provides the form or interface for editing an existing record.
- **Details**: Allows users to modify the fields of an existing record.

### `update.php`
- **Purpose**: Handles the updating of an existing record in the database.
- **Details**: Processes the data submitted from `edit.php` and updates the corresponding record in the database.

### `destroy.php`
- **Purpose**: Manages the deletion of record(s) from the database.
- **Details**: Responsible for removing one or more records based on specific criteria.

