$(document).ready(function() {
  $("#signOut").click(function(){
    location.href = "index.php?page=logout";
  });
  $("#profileButton").click(function(){
    location.href = "index.php?page=profile";
  });
  $("#activityButton").click(function(){
    location.href = "index.php?page=history";
  });
});
