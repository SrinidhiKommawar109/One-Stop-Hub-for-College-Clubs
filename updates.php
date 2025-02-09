<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Event Registration</h2>
        <form id="eventForm" enctype="multipart/form-data">
            <label for="eventName">Event Name</label>
            <input type="text" id="eventName" name="eventName" required>

            <label for="eventDescription">Event Description</label>
            <textarea id="eventDescription" name="eventDescription" rows="4" required></textarea>

            <label for="eventImage">Event Image</label>
            <input type="file" id="eventImage" name="eventImage" accept="image/*" required>

            <label for="applicationForm">Application Form URL</label>
            <input type="url" id="applicationForm" name="applicationForm" required>

            <button type="button" class="btn" onclick="submitForm()">Submit</button>
        </form>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById('eventForm');
            const formData = new FormData(form);

            fetch('store_event.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); 
                form.reset();  
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to store event.');
            });
        }
    </script>
</body>
</html>
