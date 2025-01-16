jQuery(document).ready(function($) {
    let currentSlide = 1;
    const totalSlides = 13;
    let isPlaying = false;
    let truckAnimationTimeout;
    let currentProduct = 0;
    const productsSlide11 = document.querySelectorAll('#slide-11 .product');
    
    function updateSlideCounter() {
        $('.slide-counter').text(`Stránka: ${currentSlide} / ${totalSlides}`);
    }

    function playTruckAnimation() {
        const audio = document.getElementById('truckSound');
        const $truck = $('.truck-image');
        
        if(audio) {
            $truck.addClass('active');
        }
    }

    function resetSlide(slideNumber) {
        switch(slideNumber) {
            case 2:
                const forestAudio = document.getElementById('forestSound');
                const $forestButton = $('#audioControl');
                if(forestAudio) {
                    forestAudio.pause();
                    forestAudio.currentTime = 0;
                    $forestButton.text('Spustiť zvuk').removeClass('playing');
                }
                $('.birds-container').hide();
                $('#showBirds').text('Ukázať vtáčiky').removeClass('active');
                break;
            
            case 3:
                const sawAudio = document.getElementById('sawSound');
                if(sawAudio) {
                    sawAudio.pause();
                    sawAudio.currentTime = 0;
                }
                $('.saw-image').removeClass('active');
                break;
            
            case 4:
                const truckAudio = document.getElementById('truckSound');
                if(truckAudio) {
                    truckAudio.pause();
                    truckAudio.currentTime = 0;
                }
                $('.truck-image').removeClass('active');
                $('.smoke').removeClass('active');
                break;

            case 5:
                const paperVideo = document.getElementById('paperVideo');
                if(paperVideo) {
                    paperVideo.pause();
                    paperVideo.currentTime = 0;
                }
                $('.video-container').removeClass('active');
                $('.smiley-image').show();
                break;

            case 11:
                currentProduct = 0;
                productsSlide11.forEach(product => {
                    product.classList.remove('visible');
                });
                break;
        }
    }

    function changeSlide(direction) {
        clearTimeout(truckAnimationTimeout);
        resetSlide(currentSlide);
        
        $(`#slide-${currentSlide}`).removeClass('active').fadeOut(500);
        currentSlide += direction;
        
        setTimeout(() => {
            $(`#slide-${currentSlide}`).addClass('active').fadeIn(500);
            updateNavigationVisibility();
            updateSlideCounter();

            if(currentSlide === 4) {
                truckAnimationTimeout = setTimeout(playTruckAnimation, 100);
            }
        }, 100);
    }

    function updateNavigationVisibility() {
        if (currentSlide === 1) {
            $('.prev-slide').css('visibility', 'hidden');
        } else {
            $('.prev-slide').css('visibility', 'visible');
        }
        
        if (currentSlide === totalSlides) {
            $('.next-slide').css('visibility', 'hidden');
        } else {
            $('.next-slide').css('visibility', 'visible');
        }
    }

    // Nové navigačné handlery
    $(document).on('click', 'button.next-slide', function() {
        if (currentSlide < totalSlides) {
            changeSlide(1);
        }
    });

    $(document).on('click', 'button.prev-slide', function() {
        if (currentSlide > 1) {
            changeSlide(-1);
        }
    });

    $('#audioControl').click(function() {
        const audio = document.getElementById('forestSound');
        const $button = $(this);
        
        if(audio) {
            if (audio.paused) {
                audio.play().then(() => {
                    $button.text('Zastaviť zvuk');
                    $button.addClass('playing');
                }).catch((error) => {
                    console.log('Audio play failed:', error);
                });
            } else {
                audio.pause();
                audio.currentTime = 0;
                $button.text('Spustiť zvuk');
                $button.removeClass('playing');
            }
        }
    });

    $('.play-btn').click(function() {
        isPlaying = true;
        $(this).addClass('active');
        $('.pause-btn').removeClass('active');
        
        if(currentSlide === 2) {
            const audio = document.getElementById('forestSound');
            if(audio) {
                audio.play().catch((error) => {
                    console.log('Audio play failed:', error);
                });
            }
        }
    });

    $('.stop-btn').click(function() {
        isPlaying = false;
        $('.play-btn, .pause-btn').removeClass('active');
        
        if(currentSlide === 2) {
            const audio = document.getElementById('forestSound');
            if(audio) {
                audio.pause();
                audio.currentTime = 0;
            }
        }
    });

    $('.pause-btn').click(function() {
        if (isPlaying) {
            $(this).addClass('active');
            $('.play-btn').removeClass('active');
            
            if(currentSlide === 2) {
                const audio = document.getElementById('forestSound');
                if(audio) {
                    audio.pause();
                }
            }
        } else {
            $(this).removeClass('active');
            $('.play-btn').addClass('active');
            
            if(currentSlide === 2) {
                const audio = document.getElementById('forestSound');
                if(audio) {
                    audio.play().catch((error) => {
                        console.log('Audio play failed:', error);
                    });
                }
            }
        }
        isPlaying = !isPlaying;
    });

    $('#showBirds').click(function() {
        const $button = $(this);
        const $birdsContainer = $('.birds-container');
        
        if ($birdsContainer.is(':hidden')) {
            $birdsContainer.fadeIn();
            $button.text('Skryť vtáčiky');
            $button.addClass('active');
        } else {
            $birdsContainer.fadeOut();
            $button.text('Ukázať vtáčiky');
            $button.removeClass('active');
        }
    });

    $('#startEngine').click(function() {
        const audio = document.getElementById('truckSound');
        const $smoke = $('.smoke');
        
        if(audio && audio.paused) {
            audio.play().then(() => {
                $smoke.addClass('active');
            }).catch((error) => {
                console.log('Audio play failed:', error);
            });
        }
    });

    $('#stopEngine').click(function() {
        const audio = document.getElementById('truckSound');
        const $smoke = $('.smoke');
        
        if(audio) {
            audio.pause();
            audio.currentTime = 0;
            $smoke.removeClass('active');
        }
    });

    $('.smiley-image').click(function() {
        const $videoContainer = $('.video-container');
        $(this).fadeOut(300);
        $videoContainer.addClass('active');
    });

    $('.back-to-smiley').click(function() {
        const $videoContainer = $('.video-container');
        const $smiley = $('.smiley-image');
        const video = document.getElementById('paperVideo');
        
        if(video) {
            video.pause();
            video.currentTime = 0;
        }
        
        $videoContainer.removeClass('active');
        $smiley.fadeIn(300);
    });

    // Handler pre Slider 11
    $('.paper-products').click(function() {
        if(currentSlide === 11 && currentProduct < productsSlide11.length) {
            productsSlide11[currentProduct].classList.add('visible');
            currentProduct++;
        }
    });

    $(document).keydown(function(e) {
        switch(e.which) {
            case 37:
                if (currentSlide > 1) {
                    changeSlide(-1);
                }
                break;
            case 39:
                if (currentSlide < totalSlides) {
                    changeSlide(1);
                }
                break;
            default: return;
        }
        e.preventDefault();
    });

    function stopSawAnimation($saw) {
        $saw.removeClass('active');
        $saw.css('animation', 'none');
        setTimeout(() => $saw.css('animation', ''), 10);
    }

    $('.saw-image').click(function() {
        const audio = document.getElementById('sawSound');
        const $saw = $(this);
        
        if(audio) {
            if (audio.paused) {
                audio.loop = true;
                $saw.addClass('active');
                audio.play().catch((error) => {
                    console.log('Audio play failed:', error);
                    $saw.removeClass('active');
                });
            } else {
                audio.loop = false;
                audio.pause();
                audio.currentTime = 0;
                $saw.removeClass('active');
                stopSawAnimation($saw);
            }
        }
    });

    function preloadImages() {
        const images = [
            'https://www.materskeskoly.sk/wp-content/uploads/2024/12/slider-4.jpg',
            'https://www.materskeskoly.sk/wp-content/uploads/2024/12/slider-4-nakladak.png',
            'https://www.materskeskoly.sk/wp-content/uploads/2024/12/smejo.png',
            'https://www.materskeskoly.sk/wp-content/uploads/2024/12/tovaren.png',
            'https://www.materskeskoly.sk/wp-content/uploads/2024/12/5.png',
            'https://www.materskeskoly.sk/wp-content/uploads/2024/12/4.png',
            'https://www.materskeskoly.sk/wp-content/uploads/2024/12/3.png'
        ];
        images.forEach(src => {
            const img = new Image();
            img.src = src;
        });
    }

    function init() {
        updateSlideCounter();
        updateNavigationVisibility();
        $('#slide-1').addClass('active').show();
        preloadImages();
    }

    init();
});