<audio id="audio"></audio>

<footer class="player-footer">
    <div class="song-info">
        <img id="song-artwork" src="/images/placeholder.png" alt="artwork" style="width: 50px; height: 50px; margin-right: 10px;">
        <div>
            <span id="song-title" style="display: block; font-weight: bold;">tên bài hát</span>
            <span id="song-artist" style="font-size: 0.8em;">tên ca sĩ</span>
        </div>
    </div>

    <div class="player-controls">
        <div class="control-buttons">
            <i class="fas fa-step-backward" id="prev-btn"></i>
            <i class="fas fa-play-circle play-button" id="play-btn"></i>
            <i class="fas fa-step-forward" id="next-btn"></i>
        </div>
        <div class="progress-bar-container" id="progress-container">
            <div class="progress-bar">
                <div class="progress" id="progress"></div>
            </div>
            <span id="duration">0:00</span>
        </div>
    </div>
    <div class="extra-controls">
        </div>
</footer>