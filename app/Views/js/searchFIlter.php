<script>    
    function searchFilter(page_num) {
        page_num = page_num ? page_num : 0;
        var keywords = $("#keywords").val();
        var filterDate = $("#filter-date").val();
        var sortBy = $("#sort-by").val();
        $.ajax({
            type: "POST",
            url: "http://localhost:80/Shape_Search/app/model/image_util/getSearch.php",
            data: "keywords=" + keywords + "&filterDate=" + filterDate + "&sortBy=" + sortBy + "&page=" + page_num,
            beforeSend: function() {
                $(".loading-overlay").show();
            },
            success: function(html) {
                $(".main-gallery").html(html);
                $(".loading-overlay").fadeOut("slow");
                $("#page-hide").hide();
            }
        });
    }
</script>