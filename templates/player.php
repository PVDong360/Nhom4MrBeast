<audio id="audio"></audio>

<footer class="player-bar">
    <div class="player-song-info">
        <img id="song-artwork" src="uploads/images/default_avatar.png" alt="artwork">
        <div>
            <p id="song-title">Chọn một bài hát</p>
            <p id="song-artist"></p>
        </div>
        <i class="fa-regular fa-heart" id="like-btn" style="margin-left: 30px; cursor: pointer; color: var(--color-secondary-text);"></i>
    </div>

    <div class="player-controls">
        <div class="buttons">
            <i class="fa-solid fa-shuffle" id="shuffle-btn" title="Trộn bài"></i>
            <i class="fa-solid fa-backward-step" id="prev-btn"></i>
            <i class="fa-solid fa-circle-play" id="play-btn"></i>
            <i class="fa-solid fa-forward-step" id="next-btn"></i>
            <i class="fa-solid fa-repeat" id="repeat-btn" title="Lặp lại"></i>
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
        <i class="fa-solid fa-list" id="queue-btn" title="Danh sách đang phát" style="cursor: pointer; margin-right: 15px;"></i>
        
        <i class="fa-solid fa-chevron-down" id="close-player-btn" title="Ẩn trình phát nhạc" style="margin-right: 10px;"></i>
        
        <div style="display: flex; align-items: center;">
            <i class="fa-solid fa-volume-high"></i>
            <input type="range" class="volume-slider" min="0" max="1" step="0.01">
        </div>
    </div>

    <div class="queue-popup" id="queue-popup">
        <h3>Danh sách phát</h3>
        <div class="queue-list" id="queue-list">
            </div>
    </div>
</footer>