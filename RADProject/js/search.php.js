// Once the page is loaded
$(document).ready(function () {
  // Sets the star ratings of each movie
  function refreshStars() {
    $(".star-rating").each(function () {
      resetStarRowColours(this);
    });
  }
  refreshStars();

  // onClick event for each star
  $(".fa-star").on("click", function () {
    var $star = $(this);
    id = $(this).parent().data("id");
    rating = parseInt($(this).data("index"));
    $.ajax({
      url: "includes/rateMovie.inc.php",
      method: "POST",
      data: {
        id: id,
        rating: rating,
      },
      success: function (response) {
        console.log(response);
        $star.parent().children('span[id="rating"]').text(response);
        $star.parent().data("rating", response);
        refreshStars();
      },
    });
  });

  $(".fa-star").mouseover(function () {
    var index = parseInt($(this).data("index"));
    setStars(index, $(this).parent());
  });

  $(".fa-star").mouseleave(function () {
    resetStarRowColours($(this).parent());
  });
});

function setStars(max, parent) {
  $(parent)
    .children("span")
    .each(function () {
      if ($(this).data("index") <= max) {
        $(this).css("color", "gold");
      }
      if ($(this).data("index") > max) {
        $(this).css("color", "black");
      }
    });
}

function resetStarRowColours(parent) {
  var rating = parseFloat($(parent).data("rating"));

  if (rating == 0) {
    $(parent).children("span[data-index]").css("color", "black");
  } else {
    setStars(rating, parent);
  }
}
