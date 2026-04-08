<?= view('frontend/inc/header') ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap');

.promo-wrapper {
    font-family: 'Montserrat', sans-serif;
    color: #ffffff;
    /* Deep red background with subtle vertical stripes effect */
    background: repeating-linear-gradient(
      90deg,
      #610110,
      #610110 50px,
      #53010d 50px,
      #53010d 100px
    );
    display: flex;
    min-height: 100vh;
    overflow: hidden;
    position: relative;
    padding: 60px 0;
}

.promo-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
    padding: 0 40px;
    width: 100%;
}

.promo-content {
    flex: 1 1 60%;
    max-width: 700px;
    padding-right: 40px;
}

.promo-image {
    flex: 1 1 40%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.promo-image img {
    max-width: 100%;
    height: auto;
    object-fit: contain;
    /* Optional: blend mode to mix with background better if not fully transparent */
    mix-blend-mode: screen; 
    opacity: 0.9;
}

.promo-title {
    font-size: 32px;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #ffffff;
}

.promo-desc {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 25px;
    font-weight: 400;
    color: #e5e5e5;
}

.promo-list {
    list-style: none;
    padding: 0;
    margin: 0 0 30px 20px;
}

.promo-list li {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 8px;
    position: relative;
    padding-left: 20px;
    color: #e5e5e5;
}

.promo-list li::before {
    content: "•";
    position: absolute;
    left: 0;
    top: 0;
    font-size: 20px;
    color: #ffffff;
}

.promo-divider {
    border: 0;
    height: 2px;
    background: rgba(255, 255, 255, 0.4);
    margin: 40px 0;
    width: 60%;
}

.promo-dosages {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.promo-dosage-type h4 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #ffffff;
}

@media (max-width: 991px) {
    .promo-wrapper {
        background: #5d030c; /* fallback simpler bg for mobile */
    }
    
    .promo-image {
        flex: 1 1 100%;
        margin-top: 50px;
    }
    
    .promo-content {
        flex: 1 1 100%;
        padding-right: 0;
    }
    
    .promo-divider {
        width: 100%;
    }
}
</style>

<div class="promo-wrapper">
    <div class="promo-container">
        
        <div class="promo-content">
            <h2 class="promo-title">BACKED BY TRADITION.<br>POWERED BY TRUST.</h2>
            <p class="promo-desc">
                Royal Alliance Ayurveda is a trusted name in Ayurvedic wellness, delivering high-quality herbal solutions rooted in ancient science. With decades of experience, the brand combines traditional wisdom with modern processes to ensure safe, effective, and reliable products.
            </p>
            <ul class="promo-list">
                <li>100% Organic Ayurvedic formulations</li>
                <li>Strong supply network & customer trust</li>
                <li>Focus on quality, safety, and privacy</li>
                <li>Based in Kerala – the land of Ayurveda</li>
            </ul>
            
            <hr class="promo-divider">
            
            <h2 class="promo-title">A LEGACY THAT SPEAKS<br>300+ YEARS OF AYURVEDIC HERITAGE.</h2>
            <p class="promo-desc">
                Cheetah is developed in association with Shankara's Pharma, carrying forward a deep-rooted Ayurvedic lineage.
            </p>
            <ul class="promo-list">
                <li>Inspired by ancient texts like Ashtanga Hridaya</li>
                <li>Once reserved for royal use</li>
                <li>Passed down through generations of Ayurvedic practitioners</li>
                <li>Crafted with precision for modern-day needs</li>
            </ul>
            
            <hr class="promo-divider">

            <h2 class="promo-title">USAGE & DOSAGE.</h2>
            <div class="promo-dosages">
                <div class="promo-dosage-type">
                    <h4>External Application</h4>
                    <ul class="promo-list">
                        <li>Apply 15 drops</li>
                        <li>Massage gently until absorbed</li>
                        <li>Use twice daily</li>
                    </ul>
                </div>
                <div class="promo-dosage-type">
                    <h4>Internal Intake</h4>
                    <ul class="promo-list">
                        <li>8 drops with warm milk or juice</li>
                        <li>Twice daily</li>
                    </ul>
                </div>
            </div>

            <hr class="promo-divider">

            <h2 class="promo-title">WHO IS IT FOR?</h2>
            <p class="promo-desc" style="margin-bottom: 10px;">Men seeking a natural, Ayurvedic solution for:</p>
            <ul class="promo-list">
                <li>Low stamina</li>
                <li>Performance concerns</li>
                <li>Stress-related issues</li>
                <li>Overall vitality and confidence</li>
            </ul>
        </div>
        
        <div class="promo-image">
            <img src="<?= base_url('public/assets/img/couple_line_art.png'); ?>" alt="Ayurvedic Wellness Line Art">
        </div>

    </div>
</div>

<?= view('frontend/inc/footerLink') ?>
