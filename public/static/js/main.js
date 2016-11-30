/**
 * Created by murilo on 30/11/16.
 */

var rootURL = "http://localhost:8888/users";
var createURL = "http://localhost:8888/users/create";
var findURL = "http://localhost:8888/users/find";
var updateURL = "http://localhost:8888/users/update";
var removeURL = "http://localhost:8888/users/remove";
var currentUser;

findAll();

$('#btnDelete').hide();

$('#btnAdd').click(function() {
    newUser();
    return false;
});

function newUser() {
    $('#btnDelete').hide();
    currentUser = {};
    renderDetails(currentUser);
}

function save(){
    if ($('#user_id').val() == '')
        addUser();
    else
        updateUser();
    return false;
}

function findAll() {
    $.ajax({
        type: 'GET',
        url: rootURL,
        dataType: "json",
        success: renderList
    });
}

function findById(id) {
    $.ajax({
        type: 'GET',
        url: findURL,
        data: {"id": id},
        dataType: "json",
        success: function(data){
            $('#btnDelete').show();
            currentUser = data;
            renderDetails(currentUser);
        }
    });
}

function addUser() {
    $.ajax({
        type: 'POST',
        contentType: 'application/x-www-form-urlencoded',
        url: createURL,
        dataType: "json",
        data: formToJSON(),
        success: function(data, textStatus, jqXHR){
            findAll();
            newUser();
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('addUser error: ' + textStatus);
        }
    });
}

function updateUser() {
    $.ajax({
        type: 'PUT',
        contentType: 'application/json',
        url: updateURL,
        dataType: "json",
        data: formToJSON(),
        success: function(data, textStatus, jqXHR){
            findAll();
            newUser();
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('updateWine error: ' + textStatus);
        }
    });
}

function removeUser(id) {
    $.ajax({
        type: 'DELETE',
        contentType: 'application/json',
        url: removeURL,
        dataType: "json",
        data: JSON.stringify({"user_id": id}),
        success: function(data, textStatus, jqXHR){
            findAll();
            newUser();
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('updateWine error: ' + textStatus);
        }
    });
}

function renderList(data) {
    var list = data == null ? [] : (data instanceof Array ? data : [data]);

    $('#usersList tr').remove();
    $.each(list, function(index, user) {
        $('#usersList').append('<tr id='+ user.user_id + '><td>'+ user.first_name + '</td><td>'+ user.last_name + '</td><td>'+ user.address + '</td><td><button onclick="findById(\'' + user.user_id + '\')" class="btn btn-primary" > <i class="glyphicon glyphicon-pencil"></i></button></td><td><button onclick="removeUser(\'' + user.user_id + '\')" class="btn btn-primary" > <i class="glyphicon glyphicon-remove"></i></button></td></tr>');
    });
}

function formToJSON() {
    var user_id = $('#user_id').val();
    return JSON.stringify({
        "user_id": user_id == "" ? null : user_id,
        "first_name": $('#first_name').val(),
        "last_name": $('#last_name').val(),
        "address": $('#address').val()
    });
}

function renderDetails(user) {
    $('#user_id').val(user.user_id);
    $('#first_name').val(user.first_name);
    $('#last_name').val(user.last_name);
    $('#address').val(user.address);
}
