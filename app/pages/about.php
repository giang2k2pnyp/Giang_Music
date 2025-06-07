<?php require page('includes/header')?>
<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css">

<div class="about-container">
    <div class="about-content">
        <h1>About Giang Music</h1>
        
        <div class="about-section">
            <div class="about-text">
                <h2>Our Story</h2>
                <p>
                    Founded in 2023, Giang Music started as a passion project by music enthusiast Nguyen Van Giang. 
                    What began as a small collection of local artists has grown into a vibrant platform connecting 
                    music lovers with talented artists from around the world.
                </p>
                <p>
                    We believe that music has the power to transcend boundaries and bring people together. 
                    Our mission is to create a space where both established and emerging artists can share 
                    their creations with a global audience.
                </p>
            </div>
            <div class="about-image">
                <img src="<?=ROOT?>/assets/images/about1.jpg" alt="Giang Music Studio">
            </div>
        </div>
        
        <div class="about-section reverse">
            <div class="about-text">
                <h2>What We Offer</h2>
                <ul>
                    <li>🎵 Extensive music library with thousands of tracks across all genres</li>
                    <li>🎤 Platform for independent artists to showcase their talent</li>
                    <li>🎧 High-quality streaming experience with adaptive bitrate</li>
                    <li>📱 Cross-platform compatibility (Web, iOS, Android)</li>
                    <li>🎛️ Curated playlists for every mood and occasion</li>
                    <li>🎼 Exclusive content and early releases</li>
                </ul>
            </div>
            <div class="about-image">
                <img src="<?=ROOT?>/assets/images/about2.jpg" alt="Music Collection">
            </div>
        </div>
        
        <div class="mission-section">
            <h2>Our Mission</h2>
            <div class="mission-cards">
                <div class="mission-card">
                    <div class="icon">🎯</div>
                    <h3>Empower Artists</h3>
                    <p>Provide fair compensation and promotion for creators</p>
                </div>
                <div class="mission-card">
                    <div class="icon">❤️</div>
                    <h3>Enrich Listeners</h3>
                    <p>Deliver exceptional music discovery experiences</p>
                </div>
                <div class="mission-card">
                    <div class="icon">🌍</div>
                    <h3>Global Community</h3>
                    <p>Connect music lovers across cultural boundaries</p>
                </div>
            </div>
        </div>
        
        <div class="team-section">
            <h2>Meet Our Team</h2>
            <div class="team-members">
                <div class="team-member">
                    <img src="<?=ROOT?>/assets/images/giang.jpg" alt="Nguyen Van Giang">
                    <h3>Nguyen Van Giang</h3>
                    <p>Founder & CEO</p>
                </div>
                <div class="team-member">
                    <img src="<?=ROOT?>/assets/images/team1.jpg" alt="Music Curator">
                    <h3>Le Thi Mai</h3>
                    <p>Head of Artist Relations</p>
                </div>
                <div class="team-member">
                    <img src="<?=ROOT?>/assets/images/team2.jpg" alt="Tech Lead">
                    <h3>Tran Minh Duc</h3>
                    <p>Technology Director</p>
                </div>
            </div>
        </div>
        
        <div class="cta-section">
            <h2>Join Our Musical Journey</h2>
            <p>Become part of our growing community of artists and music enthusiasts</p>
            <div class="cta-buttons">
                <a href="<?=ROOT?>/signup" class="btn-primary">Sign Up Free</a>
                <a href="<?=ROOT?>/artist-program" class="btn-secondary">Artist Program</a>
            </div>
        </div>
    </div>
</div>

<?php require page('includes/footer')?>