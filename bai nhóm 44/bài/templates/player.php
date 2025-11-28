<audio id="audio"></audio>
<footer class="player-bar">
    <div class="player-song-info">
        <img id="song-artwork" src="/images/placeholder.png" alt="artwork">
        <div>
            <p id="song-title">Chọn một bài hát</p>
            <p id="song-artist"></p>
        </div>
    </div>

    <div class="player-controls">
        <div class="buttons">
            <i class="fa-solid fa-shuffle"></i>
            <i class="fa-solid fa-backward-step" id="prev-btn"></i>
            <i class="fa-solid fa-circle-play" id="play-btn"></i>
            <i class="fa-solid fa-forward-step" id="next-btn"></i>
            <i class="fa-solid fa-repeat"></i>
        </div>
        <div class="progress-container" id="progress-container">
            <span id="current-time">0:00</span>
            <div class="progress-bar-wrapper">
                <div class="progress-bar" id="progress"></div>
            </div>
            <span id="total-duration">0:00</span>
        </div>
    </div>

    <div class="player-extra-controls">
        <i class="fa-solid fa-chevron-down" id="close-player-btn" title="Ẩn trình phát nhạc"></i>
        <i class="fa-solid fa-volume-high"></i>
        <input type="range" class="volume-slider" min="0" max="1" step="0.01">
    </div>
</footer>