"use strict";

function Home() {
    this.init();
}

Home.prototype.init = function () {
    var self = this;

    const $productsWrapper = $("#products .products-wrapper");
    app.initSlick($productsWrapper.find(".common-slider"), {
        slidesToShow: 1,
        dots: true,
        fade: true,
        arrows: false,
        speed: 500,
        cssEase: "ease",
        appendDots: $productsWrapper.find(".common-dots"),
    });

    const $newsWrapper = $("#news .news-wrapper");
    app.initSlick($newsWrapper.find(".slider"), {
        slidesToShow: 3,
        dots: true,
        arrows: false,
        speed: 500,
        cssEase: "ease",
        appendDots: $newsWrapper.find(".common-dots"),
        responsive: [
            {
                breakpoint: 960,
                settings: {
                    slidesToShow: 1,
                    fade: true,
                },
            },
        ],
    });

    const $bannersWrapper = $("#banners .banners-wrapper");
    app.initSlick($bannersWrapper, {
        autoplay: true,
        autoplaySpeed: 12000,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: false,
        dots: true,
        arrows: false,
        pauseOnHover: true,
        pauseOnFocus: true,
        cssEase: "ease",
        fade: true,
        appendDots: $bannersWrapper.parent().find(".banners-dots"),
    });
};

$(document).ready(function () {
    new Home();
});

document.addEventListener("DOMContentLoaded", function () {
    const animatedSections = document.querySelectorAll('.animate__animated');

    const options = {
        threshold: 0.5
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            const animationName = entry.target.getAttribute('data-animation');
            if (entry.isIntersecting) {
                entry.target.classList.add(animationName);
                observer.unobserve(entry.target);
            } else {
                entry.target.classList.remove(animationName);
            }
        });
    }, options);

    animatedSections.forEach(section => {
        observer.observe(section);
    });
});