<?php
include 'config.php';


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <script src="https://vk.com/js/api/openapi.js?167" type="text/javascript"></script>
</head>
<body>
<input type="button" value="Register" onclick="login()">
<script type="text/javascript">
  VK.init({
    apiId: 7331619,
  });
  function login() {
    VK.Auth.login(function(response) {
    if (response.session) {
        /* Пользователь успешно авторизовался */
        console.log(response.session);
        console.log(response.status);
    } else {
        console.log("Пользователь нажал кнопку Отмена в окне авторизации");
        /* Пользователь нажал кнопку Отмена в окне авторизации */
    }
    });
};
</script>
</body>
</html>