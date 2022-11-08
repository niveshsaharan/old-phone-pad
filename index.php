<?php require_once __DIR__ . '/functions.php';
$response = convertNumberToText(isset($_POST['input']) ? $_POST['input'] : '');
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Old Phone Pad</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<div class="wrapper">
    <!-- ## phone area -->
    <div class="phone">
        <span class="title">Old Phone Pad</span>
        <p style="text-align: center">Press # to convert.</p>
        <div class="phone-container">
            <form id="phonePadForm" method="post">
                <textarea name="input" id="input" class="number-input" placeholder="Eg. 4433555 555666#"><?php echo isset($response['input']) ? $response['input'] : ''; ?></textarea>
                <textarea name="output" id="output" class="number-input" disabled readonly placeholder="Eg. HELLO"><?php echo isset($response['data']) ? $response['data'] : ''; ?></textarea>
                <!-- ## keyboard -->
                <div class="keyboard">
                    <div class="number">
                        <span data-number="1"><i>1</i></span>
                        <span data-number="2"><i>2</i></span>
                        <span data-number="3"><i>3</i></span>
                        <span data-number="4"><i>4</i></span>
                        <span data-number="5"><i>5</i></span>
                        <span data-number="6"><i>6</i></span>
                        <span data-number="7"><i>7</i></span>
                        <span data-number="8"><i>8</i></span>
                        <span data-number="9"><i>9</i></span>
                        <span data-number="*"><i>*</i></span>
                        <span data-number="0"><i>0</i></span>
                        <span data-number="#" onclick="document.getElementById('phonePadForm').submit()"><i>#</i></span>
                    </div>
                </div>
                <input type="reset" name="reset" value="Start over" onclick="window.location.href = ''" />
            </form>
        </div>
    </div>
</div>
<script>
    let currentInputRaw = "<?php echo $response['input'] ?: ''; ?>";
    let lastPressedAt = null
    document.querySelectorAll('[data-number] i').forEach(node =>
    {
        node.addEventListener('click', function(e){
            if(! lastPressedAt || ! currentInputRaw){
                lastPressedAt = new Date().getTime();
            }

            const currentValue = e.target.parentElement.dataset.number
            if(currentValue !== '#'){
                if(lastPressedAt <= (new Date().getTime() - 1000) && currentInputRaw){
                    currentInputRaw += ' '
                }
            }
            currentInputRaw += currentValue

            document.getElementById('input').value = currentInputRaw || ''
            lastPressedAt = new Date().getTime()
        });
    });

    document.getElementById('input').addEventListener('input', function(e){
        currentInputRaw = e.target.value;
    });
</script>
</body>
</html>
