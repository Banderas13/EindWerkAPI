<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Get all users
Route::get('/users', function() {
    $users = DB::select('SELECT * FROM users');
    return response()->json($users);
});

// Get a specific user by ID
Route::get('/users/{id}', function($id){
    $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);
    if (empty($user)) {
        return response()->json(['message' => 'User not found'], 404);
    }
    return response()->json($user[0]);
});

//create a new user
Route::post('/users', function (\Illuminate\Http\Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');
    $firstname = $request->input('firstname');
    $lastname = $request->input('lastname');
    $bdate = $request->input('bdate');
    $carbeffect = $request->input('carbeffect');
    $insuline = $request->input('insuline');
    $roleid = $request->input('roleid');

    DB::insert('INSERT INTO users (email, password, firstname, lastname, bdate, carbeffect, insuline, roleid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [$email, $password, $firstname, $lastname, $bdate, $carbeffect, $insuline, $roleid]);

    return response()->json(['message' => 'User created'], 201);
});

//Update a user
Route::patch('/users/{id}', function (\Illuminate\Http\Request $request, $id) {
    //AI was used for this request
    $fields = $request->only(['email', 'password', 'firstname', 'lastname', 'bdate','carbeffect','insuline','roleid']); // Get only provided fields
    if (empty($fields)) {
        return response()->json(['message' => 'No data provided for update'], 400); // No fields to update
    }

    $setClause = [];
    $bindings = [];
    foreach ($fields as $key => $value) {
        $setClause[] = "$key = ?";
        $bindings[] = $value;
    }
    $bindings[] = $id; // Add the ID to the bindings

    $query = 'UPDATE user SET ' . implode(', ', $setClause) . ' WHERE id = ?';
    $affected = DB::update($query, $bindings);
    if ($affected === 0) {
        return response()->json(['message' => 'user not found or no changes made'], 404);
    }
    return response()->json(['message' => 'user updated successfully']);
});

//Delete a user
Route::delete('/users/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM users WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'user not found'], 404);
    }
    return response()->json(['message' => 'user deleted']);
});

// Get all roles
Route::get('/roles', function() {
    $roles = DB::select('SELECT * FROM roles');
    return response()->json($roles);
});

// Get a specific role by ID
Route::get('/roles/{id}', function($id) {
    $roles = DB::select('SELECT * FROM roles WHERE id = ?', [$id]);
    if (empty($roles)) {
        return response()->json(['message' => 'Role not found'], 404);
    }
    return response()->json($roles[0]);
});

// Create a new role
Route::post('/roles', function (\Illuminate\Http\Request $request) {
    $type = $request->input('type');

    DB::insert('INSERT INTO roles (type) VALUES (?)', [$type]);

    return response()->json(['message' => 'Role created'], 201);
});

// Update a role
Route::patch('/roles/{id}', function (\Illuminate\Http\Request $request, $id) {
    $fields = $request->only(['type']); // Get only provided fields
    if (empty($fields)) {
        return response()->json(['message' => 'No data provided for update'], 400); // No fields to update
    }

    $setClause = [];
    $bindings = [];
    foreach ($fields as $key => $value) {
        $setClause[] = "$key = ?";
        $bindings[] = $value;
    }
    $bindings[] = $id; // Add the ID to the bindings

    $query = 'UPDATE roles SET ' . implode(', ', $setClause) . ' WHERE id = ?';
    $affected = DB::update($query, $bindings);
    if ($affected === 0) {
        return response()->json(['message' => 'Role not found or no changes made'], 404);
    }
    return response()->json(['message' => 'Role updated successfully']);
});

// Delete a role
Route::delete('/roles/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM roles WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'Role not found'], 404);
    }
    return response()->json(['message' => 'Role deleted']);
});

// Get all ingredients
Route::get('/ingredients', function() {
    $ingredients = DB::select('SELECT * FROM ingredients');
    return response()->json($ingredients);
});

// Get a specific ingredient by ID
Route::get('/ingredients/{id}', function($id) {
    $ingredients = DB::select ('SELECT * FROM ingredients WHERE id = ?', [$id]);
    if (empty($ingredients)){
        return response()->json(['message' => 'Ingredient not found'], 404);
    }
    return response()->json($ingredients[0]);
});

// Create a new ingredient
Route::post('/ingredients', function (\Illuminate\Http\Request $request) {
    $name = $request->input('name');
    $typeid = $request->input('typeid');
    $carbs = $request->input('carbs');

    DB::insert('INSERT INTO ingredients (name, typeid, carbs) VALUES (?, ?, ?)', [$name, $typeid, $carbs]);

    return response()->json(['message' => 'Ingredient created'], 201);
});

// Update an ingredient
Route::patch('/ingredients/{id}', function (\Illuminate\Http\Request $request, $id) {
    $fields = $request->only(['name', 'typeid', 'carbs']); // Get only provided fields
    if (empty($fields)) {
        return response()->json(['message' => 'No data provided for update'], 400); // No fields to update
    }

    $setClause = [];
    $bindings = [];
    foreach ($fields as $key => $value) {
        $setClause[] = "$key = ?";
        $bindings[] = $value;
    }
    $bindings[] = $id; // Add the ID to the bindings

    $query = 'UPDATE ingredients SET ' . implode(', ', $setClause) . ' WHERE id = ?';
    $affected = DB::update($query, $bindings);
    if ($affected === 0) {
        return response()->json(['message' => 'Ingredient not found or no changes made'], 404);
    }
    return response()->json(['message' => 'Ingredient updated successfully']);
});

// Delete an ingredient
Route::delete('/ingredients/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM ingredients WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'Ingredient not found'], 404);
    }
    return response()->json(['message' => 'Ingredient deleted']);
});

// Get all ingredienttypes
Route::get('/ingredienttypes', function() {
    $ingredienttypes = DB::select('SELECT * FROM ingredienttypes');
    return response()->json($ingredienttypes);
});

// Get a specific ingredienttype by ID
Route::get('/ingredienttypes/{id}', function($id) {
    $ingredienttypes = DB::select('SELECT * FROM ingredienttypes WHERE id = ?', [$id]);
    if (empty($ingredienttypes)) {
        return response()->json(['message' => 'Ingredienttype not found'], 404);
    }
    return response()->json($ingredienttypes[0]);
});

// Create a new ingredienttype
Route::post('/ingredienttypes', function (\Illuminate\Http\Request $request) {
    $type = $request->input('type');

    DB::insert('INSERT INTO ingredienttypes (type) VALUES (?)', [$type]);

    return response()->json(['message' => 'Ingredienttype created'], 201);
});

// Update an ingredienttype
Route::patch('/ingredienttypes/{id}', function (\Illuminate\Http\Request $request, $id) {
    $fields = $request->only(['type']); // Get only provided fields
    if (empty($fields)) {
        return response()->json(['message' => 'No data provided for update'], 400); // No fields to update
    }

    $setClause = [];
    $bindings = [];
    foreach ($fields as $key => $value) {
        $setClause[] = "$key = ?";
        $bindings[] = $value;
    }
    $bindings[] = $id; // Add the ID to the bindings

    $query = 'UPDATE ingredienttypes SET ' . implode(', ', $setClause) . ' WHERE id = ?';
    $affected = DB::update($query, $bindings);
    if ($affected === 0) {
        return response()->json(['message' => 'Ingredienttype not found or no changes made'], 404);
    }
    return response()->json(['message' => 'Ingredienttype updated successfully']);
});

// Delete an ingredienttype
Route::delete('/ingredienttypes/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM ingredienttypes WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'Ingredienttype not found'], 404);
    }
    return response()->json(['message' => 'Ingredienttype deleted']);
});

// Get all courses
Route::get('/courses', function() {
    $courses = DB::select('SELECT * FROM courses');
    return response()->json($courses);
});

// Get a specific course by ID
Route::get('/courses/{id}', function($id) {
    $courses = DB::select('SELECT * FROM courses WHERE id = ?', [$id]);
    if (empty($courses)) {
        return response()->json(['message' => 'Course not found'], 404);
    }
    return response()->json($courses[0]);
});

// Create a new course
Route::post('/courses', function (\Illuminate\Http\Request $request) {
    $name = $request->input('name');
    $typeid = $request->input('typeid');

    DB::insert('INSERT INTO courses (name, typeid) VALUES (?, ?)', [$name, $typeid]);

    return response()->json(['message' => 'Course created'], 201);
});

// Update a course
Route::patch('/courses/{id}', function (\Illuminate\Http\Request $request, $id) {
    $fields = $request->only(['name', 'typeid']); // Get only provided fields
    if (empty($fields)) {
        return response()->json(['message' => 'No data provided for update'], 400); // No fields to update
    }

    $setClause = [];
    $bindings = [];
    foreach ($fields as $key => $value) {
        $setClause[] = "$key = ?";
        $bindings[] = $value;
    }
    $bindings[] = $id; // Add the ID to the bindings

    $query = 'UPDATE courses SET ' . implode(', ', $setClause) . ' WHERE id = ?';
    $affected = DB::update($query, $bindings);
    if ($affected === 0) {
        return response()->json(['message' => 'Course not found or no changes made'], 404);
    }
    return response()->json(['message' => 'Course updated successfully']);
});

// Delete a course
Route::delete('/courses/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM courses WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'Course not found'], 404);
    }
    return response()->json(['message' => 'Course deleted']);
});

// Get all coursetypes
Route::get('/coursetypes', function() {
    $coursetypes = DB::select('SELECT * FROM coursetypes');
    return response()->json($coursetypes);
});

// Get a specific coursetype by ID
Route::get('/coursetypes/{id}', function($id) {
    $coursetypes = DB::select('SELECT * FROM coursetypes WHERE id = ?', [$id]);
    if (empty($coursetypes)) {
        return response()->json(['message' => 'Coursetype not found'], 404);
    }
    return response()->json($coursetypes[0]);
});

// Create a new coursetype
Route::post('/coursetypes', function (\Illuminate\Http\Request $request) {
    $type = $request->input('type');

    DB::insert('INSERT INTO coursetypes (type) VALUES (?)', [$type]);

    return response()->json(['message' => 'Coursetype created'], 201);
});

// Update a coursetype
Route::patch('/coursetypes/{id}', function (\Illuminate\Http\Request $request, $id) {
    $fields = $request->only(['type']); // Get only provided fields
    if (empty($fields)) {
        return response()->json(['message' => 'No data provided for update'], 400); // No fields to update
    }

    $setClause = [];
    $bindings = [];
    foreach ($fields as $key => $value) {
        $setClause[] = "$key = ?";
        $bindings[] = $value;
    }
    $bindings[] = $id; // Add the ID to the bindings

    $query = 'UPDATE coursetypes SET ' . implode(', ', $setClause) . ' WHERE id = ?';
    $affected = DB::update($query, $bindings);
    if ($affected === 0) {
        return response()->json(['message' => 'Coursetype not found or no changes made'], 404);
    }
    return response()->json(['message' => 'Coursetype updated successfully']);
});

// Delete a coursetype
Route::delete('/coursetypes/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM coursetypes WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'Coursetype not found'], 404);
    }
    return response()->json(['message' => 'Coursetype deleted']);
});

// Get all courseingredients
Route::get('/courseingredients', function() {
    $courseingredients = DB::select('SELECT * FROM courseingredients');
    return response()->json($courseingredients);
});

// Get a specific courseingredient by ID
Route::get('/courseingredients/{id}', function($id) {
    $courseingredients = DB::select('SELECT * FROM courseingredients WHERE id = ?', [$id]);
    if (empty($courseingredients)) {
        return response()->json(['message' => 'Courseingredient not found'], 404);
    }
    return response()->json($courseingredients[0]);
});

// Create a new courseingredient
Route::post('/courseingredients', function (\Illuminate\Http\Request $request) {
    $courseid = $request->input('courseid');
    $ingredientid = $request->input('ingredientid');

    DB::insert('INSERT INTO courseingredients (courseid, ingredientid) VALUES (?, ?)', [$courseid, $ingredientid]);

    return response()->json(['message' => 'Courseingredient created'], 201);
});

// Update a courseingredient
Route::patch('/courseingredients/{id}', function (\Illuminate\Http\Request $request, $id) {
    $fields = $request->only(['courseid', 'ingredientid']); // Get only provided fields
    if (empty($fields)) {
        return response()->json(['message' => 'No data provided for update'], 400); // No fields to update
    }

    $setClause = [];
    $bindings = [];
    foreach ($fields as $key => $value) {
        $setClause[] = "$key = ?";
        $bindings[] = $value;
    }
    $bindings[] = $id; // Add the ID to the bindings

    $query = 'UPDATE courseingredients SET ' . implode(', ', $setClause) . ' WHERE id = ?';
    $affected = DB::update($query, $bindings);
    if ($affected === 0) {
        return response()->json(['message' => 'Courseingredient not found or no changes made'], 404);
    }
    return response()->json(['message' => 'Courseingredient updated successfully']);
});

// Delete a courseingredient
Route::delete('/courseingredients/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM courseingredients WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'Courseingredient not found'], 404);
    }
    return response()->json(['message' => 'Courseingredient deleted']);
});

// Get all blogs
Route::get('/blogs', function() {
    $blogs = DB::select('SELECT * FROM blogs');
    return response()->json($blogs);
});

// Get a specific blog by ID
Route::get('/blogs/{id}', function($id) {
    $blogs = DB::select('SELECT * FROM blogs WHERE id = ?', [$id]);
    if (empty($blogs)) {
        return response()->json(['message' => 'Blog not found'], 404);
    }
    return response()->json($blogs[0]);
});

// Create a new blog
Route::post('/blogs', function (\Illuminate\Http\Request $request) {
    $title = $request->input('title');
    $tagline = $request->input('tagline');
    $amount = $request->input('amount');
    $amount = $request->input('amount');
    $time = $request->input('time');
    $courseid = $request->input('courseid');

    DB::insert('INSERT INTO blogs (title, tagline, amount, time, courseid) VALUES (?, ?, ?, ?, ?)', [$title, $tagline, $amount, $time, $courseid]);

    return response()->json(['message' => 'Blog created'], 201);
});

// Update a blog
Route::patch('/blogs/{id}', function (\Illuminate\Http\Request $request, $id) {
    $fields = $request->only(['title', 'tagline', 'amount', 'time', 'courseid']); // Get only provided fields
    if (empty($fields)) {
        return response()->json(['message' => 'No data provided for update'], 400); // No fields to update
    }

    $setClause = [];
    $bindings = [];
    foreach ($fields as $key => $value) {
        $setClause[] = "$key = ?";
        $bindings[] = $value;
    }
    $bindings[] = $id; // Add the ID to the bindings

    $query = 'UPDATE blogs SET ' . implode(', ', $setClause) . ' WHERE id = ?';
    $affected = DB::update($query, $bindings);
    if ($affected === 0) {
        return response()->json(['message' => 'Blog not found or no changes made'], 404);
    }
    return response()->json(['message' => 'Blog updated successfully']);
});

// Delete a blog
Route::delete('/blogs/{id}', function ($id) {
    $deleted = DB::delete('DELETE FROM blogs WHERE id = ?', [$id]);
    if ($deleted === 0) {
        return response()->json(['message' => 'Blog not found'], 404);
    }
    return response()->json(['message' => 'Blog deleted']);
});
