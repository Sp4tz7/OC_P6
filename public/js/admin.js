var Admin = function () {

    var initAdmin = function () {

        (function ($) {
            "use strict";

            // Add active state to sidbar nav links
            var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
            $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
                if (this.href === path) {
                    $(this).addClass("active");
                }
            });

            // Toggle the side navigation
            $("#sidebarToggle").on("click", function (e) {
                e.preventDefault();
                $("body").toggleClass("sb-sidenav-toggled");
            });


            // Toggle the side navigation
            $("[data-delete]").on("click", function (e) {
                e.preventDefault();
                if (confirm("Do you want to delete this image?")) {
                    fetch(this.getAttribute("href"), {
                        method: "DELETE",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({"_token": this.dataset.token})
                    }).then(
                        (response) => response.json()
                    ).then(data => {
                        if (data.success) {
                            $(this).parent('div').remove();
                            Command: toastr.success("Image(s) supprimée(s)", "Confirmation");
                        } else {
                            alert(data.error)
                        }
                    }).catch((e) => alert(e))
                }
            });

            // Toggle the side navigation
            $("[data-delete-all]").on("click", function (e) {
                e.preventDefault();
                // On demande confirmation
                if (confirm("Dou you want to delete all images?")) {
                    // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
                    fetch(this.getAttribute("href"), {
                        method: "DELETE",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({"_token": this.dataset.token})
                    }).then(
                        // On récupère la réponse en JSON
                        response => response.json()
                    ).then(data => {
                        if (data.success) {
                            $(".portfolio-image").remove();
                            Command: toastr.success("Images deleted", "Confirmation");
                        } else {
                            alert(data.error)
                        }
                    }).catch(e => alert(e))
                }
            });

            var $collectionImg;
            var $collectionVideo;

            var $addNewImg = $('<div class="button-holder"><button type="button" class="btn btn-info">Add an image</button></div>');
            var $addVideoButton = $('<div class="button-holder"><button type="button" class="btn btn-info">Add a video</button></div>');

            //get the collectionImg
            $collectionImg = $('#trick_images_list');
            //get the collectionVideo
            $collectionVideo = $('#trick_videos_list');
            //append the add new img to the collectionImg
            $collectionImg.append($addNewImg);
            $collectionVideo.append($addVideoButton);
            // number of index
            $collectionImg.data('index', $collectionImg.find('.card').length);
            $collectionVideo.data('index', $collectionImg.find('.card').length);

            function addNewFormVideo() {
                //getting the prototype
                var prototype = $collectionVideo.data("prototype");
                // get index
                var index = $collectionVideo.data("index");
                // create the form
                var newForm = prototype;

                newForm = newForm.replace(/__name__/g, index);

                $collectionVideo.data("index", index + 1);

                // create the card
                var $card = $("<div class=\"card video-card mb-3\"></div>");
                //create heading card
                // var $cardheading = $('<div class="card-heading"><img id="blah" src="#" alt="your image" class="img-fluid mb-3" style="max-height: 300px"/></div>');
                // append cardheading in card
                // $card.append($cardheading);
                //create the panel-body and append the form to it
                var $cardBody = $("<div class=\"card-body video-card\"></div>").append(newForm);
                // append the body to the card
                $card.append($cardBody);
                // append the removebutton to the new panel
                addRemoveButton($card);

                //append the panel to the addnewitem
                $addVideoButton.before($card);
            }


            function addRemoveButton($panel) {
                // create remove button
                var $removeButton = $("<a href=\"#\" class=\"btn btn-danger\">Delete</a>");
                // card footer
                var $cardFooter = $("<div class=\"card-footer\"></div>").append($removeButton);

                // handle the click event of the remove button

                $removeButton.click(function (e) {
                    e.preventDefault();
                    $(e.target).parents(".item-card").slideUp(1000, function () {
                        $(this).remove();
                    });
                });

                //append the footer to the card
                $panel.append($cardFooter);
            }

            function addNewFormImg() {
                //getting the prototype
                var prototype = $collectionImg.data("prototype");
                // get index
                var index = $collectionImg.data("index");
                // create the form
                var newForm = prototype;

                newForm = newForm.replace(/__name__/g, index);

                $collectionImg.data("index", index + 1);

                // create the card
                var $card = $("<div class=\"card item-card col-md-5 m-3\"></div>");
                //create heading card
                // var $cardheading = $('<div class="card-heading"><img id="blah" src="#" alt="your image" class="img-fluid mb-3" style="max-height: 300px"/></div>');
                // append cardheading in card
                // $card.append($cardheading);
                //create the panel-body and append the form to it
                var $cardBody = $("<div class=\"card-body\"><div class=\"card-heading\"><img id=\"blah\" src=\"#\" alt=\"\" class=\"img-fluid mb-3\" style=\"max-height: 300px\"/></div></div>").append(newForm);
                // append the body to the card
                $card.append($cardBody);
                // append the removebutton to the new panel
                addRemoveButton($card);

                //append the panel to the addnewitem
                $addNewImg.before($card);
            }

// add remove button to existing items
            $collectionImg.find(".card").each(function () {
                addRemoveButton($(this));
            });

            $collectionVideo.find("fieldset").each(function () {
                addRemoveButton($(this));
            });

// handle the click event for addnewImg
            $addNewImg.click(function (e) {
                e.preventDefault();
                // create a new form and append it to the collectionImg
                addNewFormImg();
            });

// handle the click event for addnewVideo
            $addVideoButton.click(function (e) {
                e.preventDefault();
                // create a new form and append it to the collectionImg
                addNewFormVideo();
            });

        })(jQuery);

    }

    return {
        init: function () {
            initAdmin();

        }

    };

}();

jQuery(document).ready(function () {
    Admin.init();
});