var search = new SearchCache();
var searchKeywords = <?php echo json_encode($words) ?>;

function test() {
  var w2 = window.open(searchKeywords, 'WIDTH=400,HEIGHT=650');
}