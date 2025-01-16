<?php
function dt_enqueue_styles() {
    $parenthandle = 'divi-style'; 
    $theme = wp_get_theme();
    wp_enqueue_style($parenthandle, get_template_directory_uri() . '/style.css', array(), $theme->parent()->get('Version'));
    wp_enqueue_style('child-style', get_stylesheet_uri(), array($parenthandle), $theme->get('Version'));
}
add_action('wp_enqueue_scripts', 'dt_enqueue_styles');

function add_meta_description() {
    if (is_singular()) {
        global $post;
        $meta_description = get_post_meta($post->ID, 'meta_description', true);
        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'add_meta_description');

function paper_presentation_assets() {
    $css_version = filemtime(get_stylesheet_directory() . '/css/paper-presentation.css');
    
    wp_enqueue_style('paper-presentation-style', 
        get_stylesheet_directory_uri() . '/css/paper-presentation.css',
        array(),
        $css_version
    );
    wp_enqueue_script('paper-presentation-script',
        get_stylesheet_directory_uri() . '/js/paper-presentation.js',
        array('jquery'),
        '1.0.0',
        true
    );
    // Preload obrázkov
    add_action('wp_head', function() {
        echo '
        <link rel="preload" href="https://www.materskeskoly.sk/wp-content/uploads/2024/12/slider-4.jpg" as="image">
        <link rel="preload" href="https://www.materskeskoly.sk/wp-content/uploads/2024/12/slider-4-nakladak.png" as="image">
        ';
    });
}
add_action('wp_enqueue_scripts', 'paper_presentation_assets');

function paper_presentation_shortcode() {
    ob_start();
    ?>
    <div class="paper-presentation">
        <div class="teacher-controls">
            <button class="prev-slide" style="visibility: hidden">← Späť</button>
            <span class="slide-counter">Stránka: 1 / 13</span>
            <button class="next-slide">Ďalej →</button>
        </div>

        <div class="slides-container">
            <div class="slide active" id="slide-1">
                <div class="slide-content">
                    <div class="content-wrapper">
                        <div class="left-content">
                            <h1>AKO VZNIKÁ PAPIER?</h1>
                            <div class="comic-strip">
                                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/comic-0041.gif" 
                                     alt="Komiks 1" 
                                     class="comic-image"
                                     loading="eager">
                                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/comic-0041.gif" 
                                     alt="Komiks 2" 
                                     class="comic-image"
                                     loading="eager">
                                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/comic-0041.gif" 
                                     alt="Komiks 3" 
                                     class="comic-image"
                                     loading="eager">
                            </div>
                            <div class="controls-text">
                                Piesne sa ovládajú tlačítkami:
                            </div>
                            <div class="playback-controls">
                                <button class="play-btn">PLAY</button>
                                <button class="stop-btn">ZASTAVIŤ</button>
                                <button class="pause-btn">POZASTAVIŤ / ZNOVA SPUSTIŤ</button>
                            </div>
                        </div>
                        <div class="right-content">
                            <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/11/a-book-114_512.gif" 
                                 alt="Komiks" 
                                 class="side-image"
                                 loading="eager">
                        </div>
                    </div>
                </div>
            </div>

            <div class="slide" id="slide-2">
                <div class="slide-content">
                    <div class="content-wrapper">
                        <div class="sun-element">
                            <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/11/slnko.png" 
                                 alt="Slnko" 
                                 class="sun-image"
                                 loading="lazy">
                        </div>
                        <h2>BOL RAZ JEDEN LES, KTORÝ BOL PLNÝ STROMOV.</h2>
                        <div class="forest-scene">
                            <div class="forest-images">
                                <div class="forest-group">
                                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/11/stromy.png" 
                                         alt="Les" 
                                         class="forest-scene-image"
                                         loading="lazy">
                                </div>
                                <div class="forest-group">
                                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/11/stromy.png" 
                                         alt="Les" 
                                         class="forest-scene-image"
                                         loading="lazy">
                                </div>
                            </div>
                            <div class="birds-container" style="display: none;">
                                <div class="bird bird1"></div>
                                <div class="bird bird2"></div>
                                <div class="bird bird3"></div>
                            </div>
                        </div>
                        <audio id="forestSound" preload="auto">
                            <source src="https://www.materskeskoly.sk/wp-content/uploads/2024/11/02.mp3" type="audio/mp3">
                        </audio>
                        <div class="questions">
                            <p>ČÍ HLAS SA OZÝVA Z LESA? / VTÁČIKY / 
                                <button id="audioControl" class="audio-control-btn">Spustiť zvuk</button>
                            </p>
                            <p>AKO LIETAJÚ VTÁČIKY? 
                                <button id="showBirds" class="birds-control-btn">Ukázať vtáčiky</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="slide" id="slide-3">
                <div class="slide-content">
                    <div class="content-wrapper">
                        <h2>Raz prišiel do lesa drevorubač a niektoré stromy zoťal, </br> alebo vypílil motorovou pílou.</h2>
                        <div class="logger-scene">
                            <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/11/drevorubac.jpg" 
                                 alt="Drevorubač" 
                                 class="logger-image"
                                 loading="lazy">
                            <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/11/motorova-pila.png" 
                                 alt="Píla" 
                                 class="saw-image"
                                 loading="lazy">
                        </div>
                        <div class="slide-footer">
                            <p>Klikni na pílu a budeš počuť jej zvuk.</p>
                            <p>Čo myslíte, deti, prečo pílil drevorubač stromy?</p>
                        </div>
                        <audio id="sawSound" preload="auto">
                            <source src="https://www.materskeskoly.sk/wp-content/uploads/2024/11/pila-1.mp3" type="audio/mp3">
                        </audio>
                    </div>
                </div>
            </div>

            <div class="slide" id="slide-4">
                <div class="slide-content">
                    <div class="content-wrapper">
                        <h2>Drevorubač so svojimi pomocníkmi naložil drevo na veľké auto </br> a ujo šofér ho odviezol do továrne.</h2>
                        <div class="truck-scene">
                            <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/slider-4.jpg" 
                                 alt="Pozadie" 
                                 class="background-image"
                                 loading="lazy">
                            <div class="smoke-container">
                                <div class="smoke"></div>
                                <div class="smoke"></div>
                                <div class="smoke"></div>
                            </div>
                            <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/slider-4-nakladak.png" 
                                 alt="Nákladné auto" 
                                 class="truck-image"
                                 loading="lazy">
                        </div>
                        <div class="slide-footer">
                            <p>Naštartuj auto kliknutím na zelené tlačítko.
                                <button id="startEngine" class="engine-control-btn">Naštartuj auto</button>
                            </p>
                            <p>Zhasni motor kliknutím na červené tlačítko.
                                <button id="stopEngine" class="engine-control-btn stop">Vypnúť motor</button>
                            </p>
                            <p>Uhádneš, kde viezol ujo šofér drevo?</p>
                        </div>
                        <audio id="truckSound" preload="auto">
                            <source src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/zvuk-nakladneho-auta.mp3" type="audio/mp3">
                        </audio>
                    </div>
                </div>
            </div>

<div class="slide" id="slide-5">
    <div class="slide-content">
        <div class="content-wrapper gradient-bg">
            <h2>Z čoho vzniká papier?</h2>
            <div class="smiley-scene">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/smejo.png" 
                     alt="Smejko" 
                     class="smiley-image"
                     loading="lazy">
                <div class="video-container">
                    <video id="paperVideo" controls>
                        <source src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/video-ako-vznika-papier.mp4" type="video/mp4">
                    </video>
                    <button class="back-to-smiley">Späť na Smejka</button>
                </div>
            </div>
            <div class="slide-footer">
                <p>Klikni na smejka a dozvieš sa to!</p>
            </div>
        </div>
    </div>
</div>

<div class="slide" id="slide-6">
    <div class="slide-content">
        <div class="content-wrapper factory-bg">
            <h2>STROMY SA DOSTALI DO TOVÁRNE,<br>KDE UJOVIA DREVO SPRACOVALI A VYROBILI Z NEHO NOVÝ PAPIER.</h2>
            
            <div class="factory-scene">
                <div class="paper-left">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/5.png" 
                         alt="Papier vľavo" 
                         class="paper-image floating">
                </div>
                
                <div class="factory-center">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/tovaren.png" 
                         alt="Továreň" 
                         class="factory-image">
                </div>
                
                <div class="notebooks-right">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/4.png" 
                         alt="Zošity" 
                         class="notebook-image floating-delayed">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/3.png" 
                         alt="Zošit" 
                         class="notebook-single floating">
                </div>
            </div>
            
            <div class="slide-footer">
                <p>AKÝ PAPIER Z NEHO VYROBILI ? / zošity, výkresy.../ </p>
            </div>
        </div>
    </div>
</div>

<div class="slide" id="slide-7">
    <div class="slide-content">
        <div class="content-wrapper gradient-bg">
            <div class="text-container">
                <h2>V ZÁVODE SA DREVO POSEKÁ SKORO AŽ NA PILINY.</h2>
                <h2>KÚSKY DREVA SA ZMIEŠAJÚ Z CHEMIKÁLIAMI<br>A UVARÍ SA HUSTÁ KAŠA.</h2>
                <h2>KAŠA SA VYBIELI, TÁ SA POTOM NANÁŠA NA BIELE SITÁ,<br>KDE SA PAPIER LISUJE.</h2>
                <h2>POTOM SA PAPIER EŠTE VYSUŠÍ A VYŽEHLÍ.<br>SUCHÝ PAPIER SA NAVÍJA NA OBROVSKÉ KOTÚČE<br>A IDE DO TLAČIARNE.</h2>
            </div>
            
            <div class="scene-wrapper">
                <div class="machine-section">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/slide-7.png" 
                         alt="Stroj" 
                         class="side-image working">
                </div>
                
                <div class="tree-section">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/ako-vznika-papier-025.png" 
                         alt="Strom s tvárou" 
                         class="center-image animated">
                </div>
                
                <div class="paper-section">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/ako-vznika-papier-034.png" 
                         alt="Kotúče papiera" 
                         class="side-image">
                </div>
            </div>
            
            <div class="slide-footer">
                <p>UKÁŽ, KDE SÚ PILINY Z DREVA A KDE SA LISUJE PAPIER?</p>
            </div>
        </div>
    </div>
</div>

<div class="slide" id="slide-8">
    <div class="slide-content">
        <div class="content-wrapper gradient-bg">
            <div class="text-container">
                <h2>NOVÝ PAPIER SA DÁ VYROBIŤ AJ ZO STARÉHO A POUŽITÉHO PAPIERA.</h2>
                <h2>PRETO SA STARÝ PAPIER ZBIERA A DÁVA SA DO TAKÝCH ZÁVODOV,</h2>
                <h2>KDE SA SPRACOVÁVA NA NOVÝ. TOMU SA HOVORÍ RECYKLÁCIA.</h2>
            </div>
            
            <div class="recycle-wrapper">
                <div class="recycle-section">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/recycle1.png" 
                         alt="Recyklácia" 
                         class="recycle-image">
                </div>
                
                <div class="paper-items">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/7.png" 
                         alt="Papier 1" 
                         class="paper-item floating">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/9.png" 
                         alt="Papier 3" 
                         class="paper-item floating-delay-1">
                </div>
            </div>
            
            <div class="slide-footer">
                <p>ČO MYSLÍTE, DETI, ČO PATRÍ MEDZI STARÝ, NEPOTREBNÝ PAPIER?</p>
            </div>
        </div>
    </div>
</div>

<div class="slide" id="slide-9">
    <div class="slide-content">
        <div class="content-wrapper gradient-bg">
            <h2>TU SA RECYKLUJE STARÝ PAPIER.</h2>
            
            <div class="recycle-steps">
                <div class="steps-text">
                    <p class="step"><strong>Zber starého papiera:</strong> Ľudia zbierajú staré noviny a papiere.</p>
                    <p class="step"><strong>Výroba papierovej kaše:</strong> Starý papier sa rozdrví na hustú kašu.</p>
                    <p class="step"><strong>Čistenie kaše:</strong> Kaša sa očistí, vybieli a pripraví na nový papier.</p>
                    <p class="step"><strong>Lisovanie:</strong> Z kaše sa lisuje nový, čistý papier.</p>
                    <p class="step"><strong>Sušenie:</strong> Papier sa suší na valcoch, aby bol pevný.</p>
                    <p class="step"><strong>Hotový papier:</strong> Na konci máme nové role papiera pripravené na použitie.</p>
                </div>
                
                <div class="process-image">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/10.png" 
                         alt="Proces 1" 
                         class="process">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/11.png" 
                         alt="Proces 2" 
                         class="process">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/12.png" 
                         alt="Proces 3" 
                         class="process">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/13.png" 
                         alt="Proces 4" 
                         class="process">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/14.png" 
                         alt="Proces 5" 
                         class="process">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/15.png" 
                         alt="Proces 6" 
                         class="process">
                </div>
            </div>
            
            <div class="slide-footer">
                <p>UKÁŽ PRSTOM CESTU<br>RECYKLÁCIE STARÉHO PAPIERA!</p>
            </div>
        </div>
    </div>
</div>

<div class="slide" id="slide-10">
    <div class="slide-content">
        <div class="content-wrapper gradient-bg">
            <h2>ZACHRÁŇ STROM ZBEROM STARÉHO PAPIERA.</h2>
            
            <div class="save-tree-scene">
                <div class="flowers left">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/17.png" 
                         alt="Kvety vľavo" 
                         class="flowers-image floating">
                </div>
                
                <div class="center-tree">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/20.png" 
                         alt="Strom" 
                         class="tree-image">
                </div>
                
                <div class="flowers right">
                    <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/16.png" 
                         alt="Kvety vpravo" 
                         class="flowers-image floating-delayed">
                </div>
            </div>
            
            <div class="slide-footer">
                <p>VIEŠ PREČO SA ZBEROM STARÉHO PAPIERA ZACHRÁNIA<br>STROMY?</p>
            </div>
        </div>
    </div>
</div>

<div class="slide" id="slide-11">
    <div class="slide-content">
        <div class="content-wrapper gradient-bg">
            <div class="title-container">
                <h2>DETI POZNÁTE NEJAKÉ VECI, KTORÉ SÚ VYROBENÉ Z PAPIERA?</h2>
                <h3>KEĎ BUDEŠ KLIKAŤ MYŠOU POSTUPNE SA TI UKÁŽU.</h3>
            </div>
            
            <div class="paper-products">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/ako-vznika-papier-027.png" 
                     alt="Produkt 1" 
                     class="product hidden">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/ako-vznika-papier-042.png" 
                     alt="Produkt 2" 
                     class="product hidden">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/ako-vznika-papier-029.png" 
                     alt="Produkt 3" 
                     class="product hidden">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/ako-vznika-papier-026.png" 
                     alt="Produkt 4" 
                     class="product hidden">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/ako-vznika-papier-024.png" 
                     alt="Produkt 5" 
                     class="product hidden">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/ako-vznika-papier-040.png" 
                     alt="Produkt 6" 
                     class="product hidden">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/3.png" 
                     alt="Produkt 7" 
                     class="product hidden">
                <img src="https://www.materskeskoly.sk/wp-content/uploads/2024/12/5.png" 
                     alt="Produkt 8" 
                     class="product hidden">
            </div>
            
            <div class="slide-footer">
                <p>POVEDZ, ČO VŠETKO SA EŠTE Z PAPIERA MÔŽE VYRÁBAŤ?</p>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('paper_presentation', 'paper_presentation_shortcode');