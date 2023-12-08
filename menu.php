<div id="menu">
    <a href="index.php">Home</a>
    <a href="resultate.php">Meine Resultate</a>
    <a href="help.php">Hilfe</a>
      <form method="post" action="index.php">
          <button type="submit" name="logout" id="logoutButton">Logout</button>
      </form>
      <p id="version">V1.0.0</p>
</div>

<script>
    function toggleMenu() {
        var menu = document.getElementById("menu");
        if (menu.style.display === "block") {
            menu.style.display = "none";
        } else {
            menu.style.display = "block";
        }
    }
</script>
