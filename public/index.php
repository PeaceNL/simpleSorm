<!DOCTYPE html>
<html>
<head>
    <title>Phone Number Validation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="phoneForm">
        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" required>
        <button type="submit">Validate</button>
    </form>
    <div id="message"></div>
    <div id="check"></div>

    <script>
        $(document).ready(function() {
            console.log("запустился")
            $('#phoneForm').submit(function(event) {
                event.preventDefault(); // Предотвращаем стандартное поведение отправки формы

                var formData = $(this).serialize(); // Сериализуем данные формы
                console.log(formData)
                $.ajax({
                    type: 'POST',
                    url: '../server.php', // Путь к обработчику на сервере
                    data: formData,
                    dataType: 'json', // Ожидаемый тип данных
                    success: function(response) {
                        if(response.success) {
                            $('#message').text(response.message);
                            $('#check').text(response.check);
                        } else {
                            $('#message').text(response.message);
                            $('#check').text(response.check);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
            });
        });
    </script>
</body>
</html>