<!doctype html>
<body>
<input type="number" id="test"> oninput: <span id="result"></span>
<script>
  test.oninput = function() {
    result.innerHTML = test.value;
  };
</script>
</body>