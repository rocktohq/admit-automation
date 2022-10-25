// === AJAX === \\

$(document).ready(function() {
    displayData();
});

// Display Data
function displayData() {
    let displayData = true;
    $.ajax({
        url: "actions.php?action=showdata",
        type: "post",
        data: {
            displayData: displayData
        },
        success: function(data, status) {
            $('#displayDataTable').html(data);
        }
    });
}

// Add User
function adduser() {
    let sName = $('#sname').val();
    let sUid = $('#uid').val();

    if (!sName) {
        let element = document.getElementById("rsname");
        element.classList.add("text-danger");
        element.innerHTML = "* Required!";
    } else if (!sUid) {
        let element = document.getElementById("ruid");
        element.classList.add("text-danger");
        element.innerHTML = "* Required!";
    } else {
        $.ajax({
            url: "actions.php?action=insertdata",
            type: "post",
            data: {
                Name: sName,
                Uid: sUid
            },
            success: function(data, status) {
                // Display message
                $('#notification').html(data)
                $(".toast").toast('show');

                // Display the current list
                displayData();
                $('#modalAdd').modal("hide");
            }
        });
        preventDefault();
    }
}

// Delete User
function deleteUser(deleteId) {
    $('#delid').val(deleteId);
    $('#modalDelete').modal('show');
}

function delUser() {
    let deleteId = $('#delid').val();
    $.ajax({
        url: "actions.php?action=deletedata",
        type: "post",
        data: {
            deleteId: deleteId
        },
        success: function(data, status) {
            $('#modalDelete').modal('hide');
            $('#notification').html(data)
            $(".toast").toast('show');
            displayData();
        }
    });
}

//Update User
function updateUser(upId) {
    $('#updateId').val(upId);
    $.post("a.php?action=updatedata", { upId: upId }, function(data, status) {
        let id = JSON.parse(data);
        $('#sname').val(id.name);
    });

    $('#modalUpdate').modal("show");
}

function updateData() {
    let newName = $('#name').val();
    let newUid = $('#sid').val();
    let id = $('#updateId').val();
    $.post("actions.php?action=update", {
            newName: newName,
            newUid: newUid,
            id: id
        },
        function(data, status) {
            $('#modalUpdate').modal("hide");
            $('#notification').html(data)
            $(".toast").toast('show');
            displayData();
        });
}