<div class='filter-bar'>
    
    <select class='filter' id='filter-date' onchange='searchFilter();'>
        <option value="">Date Uploaded</option>
        <option value="">Any</option>
        <option value=" DATE_SUB(NOW(), INTERVAL 1 DAY) ">Last Day</option>
        <option value=" DATE_SUB(NOW(), INTERVAL 1 WEEK) ">Last Week</option>
        <option value=" DATE_SUB(NOW(), INTERVAL 1 MONTH) ">Last Month</option>
        <option value=" DATE_SUB(NOW(), INTERVAL 1 YEAR) ">Last Year</option>
    </select>

    <select class='filter' id='sort-by' onchange='searchFilter();'>
        <option value=''>Sort By</option>
        <option value='id'>Newest</option>
        <option value='like_num'>Most Liked</option>
        <option value='favorite_num'>Most Favorited</option>
        <option value='view_num'>Most Viewed</option>
    </select>
</div>