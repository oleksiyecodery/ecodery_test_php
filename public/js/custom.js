$(function () {
    var dataUrl = "imdbtop/";
    var moviesDiv = $('.all-movies .movies-list');
    var paginationDiv = $('.all-movies .pagination');

    function loadPosts(data) {
        function updateContent(jContainer, templateId, data) {
            jContainer.empty();
            var source = $(templateId).html();
            var template = Handlebars.compile(source);
            jContainer.append(template(data));
        }

        updateContent(moviesDiv, "#movies-template", data.movies);
        updateContent(paginationDiv, "#pagination-template", {
            'isPrev': +data.page - 1 >= 0,
            'isNext': +data.page + 1 < +data.maxPage,
            'prev': +data.page - 1,
            'next': +data.page + 1
        });
    }

    function render(url) {
        function getJson(url) {
            $.ajax({
                dataType: "json",
                url: url,
                success: function (json) {
                    loadPosts(json);
                }
            });
            return 1;
        }

        var temp = url.split("/")[0];

        if (temp === "#page") {
            var index = url.split("#page/")[1].trim();
            getJson(dataUrl + index)
        } else {
            getJson(dataUrl)
        }
    }

    $(window).on("hashchange", function () {
        render(window.location.hash);
    });

    $(window).trigger("hashchange");
});