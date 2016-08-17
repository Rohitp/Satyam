var apiUrl = "../satyam/api";
var repeat = false;

var apiCall = {
  search : function(query) {
    var url = apiUrl +'/search.php?query=' + query;
    return Promise.resolve($.ajax(url));
  },

  get : function(id) {
    var url = apiUrl + '/get.php?id=' + id;
    return Promise.resolve($.ajax(url));
  },

  related: function(id) {
      var url = apiUrl + '/recommend.php?id=' + id;
      return Promise.resolve($.ajax(url));
  }
}


function init() {
  //godfather
  apiCall.get("238").then(createRootNode);
}

function createRootNode(node) {
  // console.log("Here");
  // console.log(node);
  dndTree.setRootMovie(node);

}

window.onresize = function () {
    dndTree.resizeOverlay();
    var height = $(window).height();
    $('#rightpane').height(height);
};

$('#rightpane').height($(window).height());


init();

function getRelated(node, exclude) {
    // console.log(node);
    return new Promise(function (resolve, reject) {
        // TODO remove repeat artists
        return apiCall.related(node.id).then(function (data) {
            if (!repeat) {
                console.log(data);
                data.books = data.books.filter(function (books) {
                    return exclude.indexOf(books.id) === -1;
                });
            }
            resolve(data.books);
        });
    });
}

var getInfoTimeoutid;
function getInfo(movie) {
    getInfoTimeoutid = window.setTimeout(function () {
        _getInfo(movie);
        $('#rightpane').animate({ scrollTop: '0px' });
    }, 500);
}

function getInfoCancel(movie) {
    window.clearTimeout(getInfoTimeoutid);
}

function _getInfo(movie) {
    console.log(movie)

}

function searchMovie() {
  // console.log($("#movie-search").val());
  apiCall.search($("#movie-search").val())
         .then(function (data) {
          //  console.log(data);
         if (data && data.length) {
          //  console.log("Here");
            console.log(data[0]);
             createRootNode(data[0]);
         }
     });
}

function getMovieInfo(id) {
  apiCall.get(id)
         .then(function (data) {
          //  console.log(data);
         if (data) {
          //  console.log("Here");
            console.log(data);
            //  createRootNode(data[0]);
         }
     });
}


window.AE = {
    getRelated: getRelated,
    apiUrl: apiUrl,
    getInfoCancel: getInfoCancel,
    getInfo: getInfo,
    getMovieInfo: getMovieInfo
};
