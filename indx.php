<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Registration Form</title>
<style>
/* same styling (slightly cleaned) */
body { font-family: Arial, sans-serif; 
    margin:0; 
    padding:20px;
     background:#f4f4f4; }

.container { background:#fff; 
    padding:20px; 
    border-radius:8px; 
    box-shadow:0 0 10px rgba(0,0,0,.08);
     max-width:600px;
      margin:0 auto 20px; }

h1 { text-align:center; 
    margin-bottom:16px;
 }

.form-group { margin-bottom:12px; 
}

label { display:block; 
    margin-bottom:6px;
     font-size:14px; 
    }
input[type="text"], input[type="email"], input[type="number"], input[type="tel"], textarea, input[type="password"] {
  width:100%; 
  padding:10px;
   box-sizing:border-box; 
   border:1px solid #ddd;
    border-radius:4px;
}
input[type="submit"] { padding:10px 16px; 
    border:0;
     border-radius:4px; 
     background:#007bff;
      color:#fff; 
      cursor:pointer; 
    }
.error { color:#d9534f; 
    font-size:13px; 
    margin-top:6px;
 }
.success { color:#28a745; 
    font-size:14px;
     margin:10px 0;
     }
table { width:100%;
     border-collapse:collapse; 
     max-width:1000px; margin:0 auto;
      background:#fff; 
    }
th,td { padding:8px;
     border:1px solid #eaeaea;
      text-align:left; 
      font-size:13px;
     }
th {
     background:#f8f9fa;
     }
.btn-edit, .btn-delete { padding:6px 8px; 
    border:0; 
    border-radius:4px; 
    color:#fff; 
    cursor:pointer;
     font-size:12px; 
    }
.btn-edit {
     background:#007bff; 
    }
.btn-delete {
     background:#dc3545;
      }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
  <h1>Registration Form</h1>

  <form id="registration-form" method="post">
    <input type="hidden" id="record-id" name="record-id" value="">

    <div class="form-group">
      <label for="first-name">First Name:</label>
      <input type="text" id="first-name" name="firstname">
    </div>

    <div class="form-group">
      <label for="last-name">Last Name:</label>
      <input type="text" id="last-name" name="lastname">
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email">
    </div>

    <div class="form-group">
      <label for="age">Age:</label>
      <input type="number" id="age" name="age" min="1" max="120">
    </div>

    <div class="form-group">
      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="phone" pattern="[0-9]{10}">
    </div>

    <div class="form-group">
      <label for="address">Address:</label>
      <textarea id="address" name="address" rows="3"></textarea>
    </div>

    <div class="form-group" id="password-container">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password">
    </div>

    <div class="form-group">
      <input type="submit" value="Submit">
    </div>
  </form>
</div>

<table id="table">
  <thead>
    <tr>
      <th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Age</th><th>Phone</th><th>Address</th><th>Password</th><th colspan="2">Operation</th>
    </tr>
  </thead>
  <tbody><!-- dynamic --></tbody>
</table>

<script>
$(document).ready(function() {
  // Load table rows from server
  function loadTable() {
    $.ajax({
      url: 'select.php',
      type: 'POST',
      cache: false,
      success: function(data) {
        $('#table tbody').html(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('loadTable Error:', textStatus, errorThrown);
        $('#table tbody').html('<tr><td colspan="10">An error occurred while fetching data.</td></tr>');
      }
    });
  }

  // Validation function (must return boolean)
  function validateForm() {
    let isValid = true;
    $('.error').remove();

    const nameRegex = /^[A-Za-z]+$/;
    const firstName = $('#first-name').val().trim();
    if (!firstName || !nameRegex.test(firstName)) {
      $('#first-name').after('<div class="error">First name must contain only letters.</div>');
      isValid = false;
    }

    const lastName = $('#last-name').val().trim();
    if (!lastName || !nameRegex.test(lastName)) {
      $('#last-name').after('<div class="error">Last name must contain only letters.</div>');
      isValid = false;
    }

    const email = $('#email').val().trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailRegex.test(email)) {
      $('#email').after('<div class="error">Please enter a valid email address.</div>');
      isValid = false;
    }

    const ageVal = $('#age').val();
    const age = parseInt(ageVal, 10);
    if (isNaN(age) || age < 18) {
      $('#age').after('<div class="error">Age must be 18 or older.</div>');
      isValid = false;
    }

    const phone = $('#phone').val().trim();
    const phoneRegex = /^[0-9]{10}$/;
    if (!phone || !phoneRegex.test(phone)) {
      $('#phone').after('<div class="error">Phone number must be a valid 10-digit number.</div>');
      isValid = false;
    }

    const address = $('#address').val().trim();
    if (!address) {
      $('#address').after('<div class="error">Address cannot be empty.</div>');
      isValid = false;
    }

    // Normal-strong password: min 6 chars, at least one letter and one number
    // Password validation (simple: at least 6 characters)
const password = $('#password').val();
if ($('#password-container').is(':visible')) {
  if (!password || password.trim() === '') {
    $('#password').after('<div class="error">Password cannot be empty.</div>');
    isValid = false;
  } else if (password.length < 6) {
    $('#password').after('<div class="error">Password must be at least 6 characters long.</div>');
    isValid = false;
  }
}


    return isValid;
  }

  // Submit handler (insert or update)
  $('#registration-form').on('submit', function(event) {
    event.preventDefault();
    // clear previous messages
    $('#registration-form .success, #registration-form .error').remove();

    if (!validateForm()) return;

    const recordId = $('#record-id').val();
    const url = recordId ? 'update.php' : 'insrt.php';

    $.ajax({
      type: 'POST',
      url: url,
      data: $(this).serialize(),
      success: function(response) {
        // show response and reload table
        $('#registration-form').prepend('<div class="success">' + response + '</div>');
        $('#registration-form')[0].reset();
        $('#record-id').val('');
        $('#password-container').show();
        $('input[type="submit"]').val('Submit');
        loadTable();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Submit Error:', textStatus, errorThrown);
        $('#registration-form').prepend('<div class="error">An error occurred. Please try again.</div>');
      }
    });
  });

  // Edit button -> fetch single record
  $('#table').on('click', '.btn-edit', function() {
    const id = $(this).data('id');
    $.ajax({
      url: 'select_single.php',
      type: 'POST',
      data: { id: id },
      success: function(data) {
        try {
          const record = JSON.parse(data);
          if (record.error) { alert(record.error); return; }
          $('#record-id').val(record.id);
          $('#first-name').val(record.firstname);
          $('#last-name').val(record.lastname);
          $('#email').val(record.email);
          $('#age').val(record.age);
          $('#phone').val(record.phone);
          $('#address').val(record.address);
          $('#password').val(''); // don't fill password
          $('#password-container').hide(); // hide for update (user can leave empty)
          $('input[type="submit"]').val('Update');
        } catch (e) {
          console.error('parse error', e, data);
          alert('An error occurred while processing the record.');
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('select_single error', textStatus, errorThrown);
        alert('An error occurred while fetching the record.');
      }
    });
  });

  // Delete button
  $('#table').on('click', '.btn-delete', function() {
    const id = $(this).data('id');
    if (!confirm('Are you sure you want to delete this record?')) return;

    $.ajax({
      url: 'delete.php',
      type: 'POST',
      data: { id: id },
      success: function(response) {
        if (response.trim() === "Record deleted successfully.") {
          loadTable();
        } else {
          alert('Delete error: ' + response);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('delete error', textStatus, errorThrown);
        alert('An error occurred. Please try again.');
      }
    });
  });

  // initial load
  loadTable();
});
</script>
</body>
</html>
