<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Subskrypcja: Zadanie 2 i 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        input, select {
            margin: 3px;
            padding:5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-delete {
            margin: 3px;
        }

        table tr td {
            padding: 5px;
            vertical-align: middle;
        }

        .btn-xs {
            padding: 2px 7px 3px 7px;
            border-radius:5px;
            font-size: 13px;
        }

        input[type="radio"] {
            margin: 0 5px;
            vertical-align: middle;
            cursor: pointer;
        }

        .subscription{
            label{
                border:1px solid #ddd;
                padding: 3px 10px  5px 5px;
                border-radius: 5px;
                line-height: 1;
                vertical-align: middle;
                cursor: pointer;
            }
        }

        .disabled {
            opacity: 0.2!important;
            cursor: not-allowed;
        }

        .has-error {
            border: 1px solid red;
            background-color: #fff3f3;
        }
    </style>

</head>
<body>