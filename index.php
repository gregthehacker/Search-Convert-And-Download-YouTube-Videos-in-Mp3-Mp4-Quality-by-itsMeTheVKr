<style>

   .section-title {
    font-size: 45px;
    font-weight: lighter;
    color: #353535;
}
    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
    margin-bottom: .5rem;
    font-family: "Roboto",sans-serif;
    font-weight: 500;
    line-height: 1.1;
    color: inherit;
}
.h2 {
    font-size: 2rem;
}
</style>

<?php 

?>
<center><h2 class="section-title text-color-primary" id="supported-sites-title">  Search, Convert And Download Any Videos From Any Website (1000+) </h2></center>
<head>    <title> Search,Convert And Download Any Videos Form Any Website (1000+)</title>
        
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  </head>
  <body>
    

<script src="https://use.fontawesome.com/567fc88304.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>


<script>
    
    var gapikey = 'YOUTUBE API KEY';


$(function() {
    
    // call fancybox pluggin
    $(".fancyboxIframe").fancybox({
        maxWidth    : 900,
        maxHeight    : 600,
        fitToView    : false,
        width        : '90%',
        height        : '90%',
        autoSize    : false,
        closeClick    : false,
        openEffect    : 'none',
        closeEffect    : 'none',
        iframe: {
            scrolling : 'auto',
            preload   : true
        }
    });
    
    $('#search-form').submit( function(e) {
        e.preventDefault();
    });
});

function searchYoutube() {
    $('#results').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
    $('#buttons').html('');
    
    // get form input
    q = $('#search').val(); 
    
    // run get request on API
    $.get(
        "https://www.googleapis.com/youtube/v3/search", {
            part: 'snippet, id',
            q: q,
            type: 'video',
            key: gapikey
        }, function(data) {
            var nextPageToken = data.nextPageToken;
            var prevPageToken = data.prevPageToken;
            
            // Log data
            console.log(data);
            $('#results').html(''); // hide loading
            $.each(data.items, function(i, item) {
                
                // Get Output
                var output = getOutput(item);
                
                // display results
                $('#results').append(output);
            });
            
            var buttons = getButtons(prevPageToken, nextPageToken);
            
            // Display buttons
            $('#buttons').append(buttons);
        });
}

// Next page function
function nextPage() {
    var token = $('#next-button').data('token');
    var q = $('#next-button').data('query');
    
    
   // clear 
    $('#results').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
    $('#buttons').html('');
    
    // get form input
    q = $('#search').val();
    
    // run get request on API
    $.get(
        "https://www.googleapis.com/youtube/v3/search", {
            part: 'snippet, id',
            q: q,
            pageToken: token,
            type: 'video',
            key: gapikey
        }, function(data) {
            
            var nextPageToken = data.nextPageToken;
            var prevPageToken = data.prevPageToken;
            
            // Log data
            console.log(data);
            $('#results').html('');
            $.each(data.items, function(i, item) {
                
                // Get Output
                var output = getOutput(item);
                
                // display results
                $('#results').append(output);
            });
            
            var buttons = getButtons(prevPageToken, nextPageToken);
            
            // Display buttons
            $('#buttons').append(buttons);
        });    
}

// Previous page function
function prevPage() {
    var token = $('#prev-button').data('token');
    var q = $('#prev-button').data('query');
    
    
   // clear 
    $('#results').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
    $('#buttons').html('');
    
    // get form input
    q = $('#search').val();  // this probably shouldn't be created as a global
    
    // run get request on API
    $.get(
        "https://www.googleapis.com/youtube/v3/search", {
            part: 'snippet, id',
            q: q,
            pageToken: token,
            type: 'video',
            key: gapikey
        }, function(data) {
            
            var nextPageToken = data.nextPageToken;
            var prevPageToken = data.prevPageToken;
            
            // Log data
            console.log(data);
            $('#results').html('');
            $.each(data.items, function(i, item) {
                
                // Get Output
                var output = getOutput(item);
                
                // display results
                $('#results').append(output);
            });
            
            var buttons = getButtons(prevPageToken, nextPageToken);
            
            // Display buttons
            $('#buttons').append(buttons);
        });    
}

// Build output
function getOutput(item) {
    var videoID = item.id.videoId;
    var title = item.snippet.title;
    var description = item.snippet.description;
    var thumb = item.snippet.thumbnails.high.url;
    var channelTitle = item.snippet.channelTitle;
    var videoDate = item.snippet.publishedAt;
    
    // Build output string
    var output =        '<div class="col-md-6">' +
                            '<img src="' + thumb + '" class="img-responsive thumbnail" >' +
                        '</div>' +
                        '<div class="input-group col-md-6">' +
                            '<h3><a data-fancybox-type="iframe" class="fancyboxIframe" href="https://youtube.com/embed/' + videoID + '?rel=0">' + title + '</a></h3>' +
                            '<small>By <span class="channel">' + channelTitle + '</span> on ' + videoDate + '</small>' +
                            '<p>' + description + '</p>' + 
                            '<iframe  style="width:100%;height:40px;border:0;"  src="https://dlmyvid.000webhostapp.com/apis/d/?u=https://www.youtube.com/watch?v=' + videoID + '&f=mp3"></iframe>' + '<br>' + '<br>' + '<iframe  style="width:100%;height:40px;border:0;"  src="https://dlmyvid.000webhostapp.com/apis/d/?u=https://www.youtube.com/watch?v=' + videoID + '&f=720"></iframe>' + '<br><br>'+ '<a href="download/?url=https://www.youtube.com/watch?v=' + videoID + '"><button class="btn btn-info btn-lg" type="submit"> More Format </button></a>' + '<br>' +
                        '</div>' +
                    '<div class="clearfix1"></div>';
    return output;
}

function getButtons(prevPageToken, nextPageToken) {
    if(!prevPageToken) {
        var btnoutput =     '<ul class="pagination">' +
                                '<li><a href="javascript:;"  id="next-button" class="paging-button" data-token="' + nextPageToken + '" data-query="' + q + '"' +
                                    'onclick = "nextPage();">Next &raquo;</a></li>' +
                            '</ul>';
    } else {
        var btnoutput =     '<ul class="pagination">' +
                                '<li><a href="javascript:;" id="prev-button" class="paging-button" data-token="' + prevPageToken + '" data-query="' + q + '"' +
                                    'onclick = "prevPage();">&laquo; Previous</a></li>' +            
                                '<li><a href="javascript:;" id="next-button" class="paging-button" data-token="' + nextPageToken + '" data-query="' + q + '"' +
                                    'onclick = "nextPage();">Next &raquo;</a></li>' +
                            '</ul>';        
    }
    
    return btnoutput;
}
    
</script> 
<style>

    .open-button {
  background-color: red;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  bottom: 23px;
  right: 28px;
  width: 100%;
  height:40px;
}
   #custom-search-input1{
    padding: 3px;
    border: solid 1px #E4E4E4;
    border-radius: 6px;
    background-color: #fff;
}
 
#custom-search-input1 input{
    border: 0;
    box-shadow: none;
    width: 93%;
}
 
#custom-search-input1 button{
    margin: 2px 0 0 0;
    background: none;
    box-shadow: none;
    border: 0;
    color: #666666;
    padding: 0 8px 0 10px;
    border-left: solid 1px #ccc;
}
 
#custom-search-input1 button:hover{
    border: 0;
    box-shadow: none;
    border-left: solid 1px #ccc;
}
 
#custom-search-input1 .glyphicon-search{
    font-size: 23px;
}
article {
  margin: 10px 0;
  background: rgba(0,0,0,0.7);
  padding: 4px 20px;
}
 
.video-wrapper {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
  z-index:-1;
}
 
.video-wrapper video {
  position: fixed;
  top: 0;
  right: 0;
  min-width: 100%; 
  min-height: 100%;
  width: auto; 
  height: auto;
}
 
.content1 {
  position: relative;
  margin: 60px auto;
  width: 80%;
  max-width: 640px;
  z-index: 1;
}
.clearfix1{
    border-bottom: 1px dotted #ccc;
    margin-bottom: 5px;
}

</style>
<div class="content1">
     <h2> Put URL to Download Videos </h2>
            
                  <div id="custom-search-input1">
                <div class="input-group col-md-12">  
                    
                    <form action="download" method="get" name="hyv-yt-search" id="hyv-yt-search">
        <input required="" type="url" name="url"  placeholder="Put URL to Download Videos ..." class="form-control"  autocomplete="off">
        
        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="submit" id="findNow">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
      </form>

                    
                    
                </div>
            </div>
                    
                  <br>  
                    
                    
     <h2> Search YouTube Videos & Download </h2>
            <div id="custom-search-input1">
                <div class="input-group col-md-12">
                    <form id="search-form" name="search-form" onsubmit="return searchYoutube();">
                        <input  required="" name="v" type="text" class="form-control" placeholder="Put Songs Name to Search...." id="search" />
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-lg" type="submit" id="findNow">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </span>
                    </form>
                </div>
            </div>
      <div id="results"></div>
      <div id="buttons"></div>
</div></body>
</html>

<center> <h2 class="section-title text-color-primary" id="supported-sites-title">Supported Sites</h2> </center>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.fa {
  padding: 20px;
  font-size: 50px;
  width: 50px;
  text-align: center;
  text-decoration: none;
  margin: 5px 2px;
  border-radius: 50%;
}

.fa:hover {
    opacity: 0.7;
}

.fa-facebook {
  background: #3B5998;
  color: white;
}

.fa-twitter {
  background: #55ACEE;
  color: white;
}

.fa-google {
  background: #dd4b39;
  color: white;
}

.fa-linkedin {
  background: #007bb5;
  color: white;
}

.fa-youtube {
  background: #bb0000;
  color: white;
}

.fa-instagram {
  background: #125688;
  color: white;
}

.fa-pinterest {
  background: #cb2027;
  color: white;
}

.fa-snapchat-ghost {
  background: #fffc00;
  color: white;
  text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
}

.fa-skype {
  background: #00aff0;
  color: white;
}

.fa-imdb {
  background: #a4c639;
  color: white;
}

.fa-dribbble {
  background: #ea4c89;
  color: white;
}

.fa-vimeo {
  background: #45bbff;
  color: white;
}

.fa-tumblr {
  background: #2c4762;
  color: white;
}

.fa-vine {
  background: #00b489;
  color: white;
}

.fa-foursquare {
  background: #45bbff;
  color: white;
}

.fa-stumbleupon {
  background: #eb4924;
  color: white;
}

.fa-flickr {
  background: #f40083;
  color: white;
}

.fa-yahoo {
  background: #430297;
  color: white;
}

.fa-soundcloud {
  background: #ff5500;
  color: white;
}

.fa-reddit {
  background: #ff5700;
  color: white;
}

.fa-rss {
  background: #ff6600;
  color: white;
}
.fa-more {
  background: #ff6600;
  color: white;
}
</style>
</head>
<body>


<!-- Add font awesome icons -->
<a href="#" class="fa fa-facebook"></a>
<a href="#" class="fa fa-twitter"></a>
<a href="#" class="fa fa-google"></a>
<a href="#" class="fa fa-linkedin"></a>
<a href="#" class="fa fa-youtube"></a>
<a href="#" class="fa fa-instagram"></a>
<a href="#" class="fa fa-pinterest"></a>
<a href="#" class="fa fa-snapchat-ghost"></a>
<a href="#" class="fa fa-skype"></a>
<a href="#" class="fa fa-dribbble"></a>
<a href="#" class="fa fa-vimeo"></a>
<a href="#" class="fa fa-tumblr"></a>
<a href="#" class="fa fa-vine"></a>
<a href="#" class="fa fa-foursquare"></a>
<a href="#" class="fa fa-stumbleupon"></a>
<a href="#" class="fa fa-flickr"></a>
<a href="#" class="fa fa-yahoo"></a>
<a href="#" class="fa fa-reddit"></a>
<a href="#" class="fa fa-rss"></a>
<a href="#" class="fa fa-imdb"></a>
<img class="fa fa-more" src="https://www.logolynx.com/images/logolynx/9e/9e416d753c5e058caaf238fcd2bcc62e.png">
      
</body>
</html> 


