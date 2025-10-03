// Lấy các phần tử HTML từ DOM
const playBtn = document.getElementById("play-btn");
const prevBtn = document.getElementById("prev-btn");
const nextBtn = document.getElementById("next-btn");
const audio = document.getElementById("audio");
const progress = document.getElementById("progress");
const progressContainer = document.getElementById("progress-container");
const songTitleEl = document.getElementById("song-title");
const songArtistEl = document.getElementById("song-artist");
const songArtworkEl = document.getElementById("song-artwork");
const currentTimeEl = document.getElementById("current-time");
const totalDurationEl = document.getElementById("total-duration");
const volumeSlider = document.querySelector(".volume-slider");

// Biến trạng thái
let songIndex = 0;
let isPlaying = false;
let playlist = []; // Mảng này sẽ được điền dữ liệu từ CSDL

// Hàm fetch danh sách bài hát từ API
async function fetchSongs() {
  try {
    const response = await fetch("api_get_songs.php");
    playlist = await response.json();
    // Không tự động tải bài đầu tiên, đợi người dùng click
    setupMusicCards();
  } catch (error) {
    console.error("Không thể lấy danh sách bài hát:", error);
  }
}

// Tải một bài hát cụ thể vào trình phát
function loadSong(song) {
  songTitleEl.innerText = song.ten_bai_hat;
  songArtistEl.innerText = song.ca_si;
  songArtworkEl.src = song.hinh_anh;
  audio.src = song.file_mp3;
}

// Phát nhạc
function playSong() {
  isPlaying = true;
  playBtn.classList.remove("fa-circle-play");
  playBtn.classList.add("fa-circle-pause");
  audio.play();
}

// Dừng nhạc
function pauseSong() {
  isPlaying = false;
  playBtn.classList.remove("fa-circle-pause");
  playBtn.classList.add("fa-circle-play");
  audio.pause();
}

// Chuyển bài hát tiếp theo
function nextSong() {
  songIndex++;
  if (songIndex >= playlist.length) songIndex = 0;
  loadSong(playlist[songIndex]);
  playSong();
}

// Chuyển bài hát trước đó
function prevSong() {
  songIndex--;
  if (songIndex < 0) songIndex = playlist.length - 1;
  loadSong(playlist[songIndex]);
  playSong();
}

// Cập nhật thanh tiến trình và thời gian
function updateProgress(e) {
  const { duration, currentTime } = e.srcElement;

  // Cập nhật thanh tiến trình
  const progressPercent = (currentTime / duration) * 100;
  progress.style.width = `${progressPercent}%`;

  // Cập nhật tổng thời gian (chỉ một lần)
  if (duration) {
    let totalMinutes = Math.floor(duration / 60);
    let totalSeconds = Math.floor(duration % 60);
    totalDurationEl.textContent = `${totalMinutes}:${
      totalSeconds < 10 ? "0" : ""
    }${totalSeconds}`;
  }

  // Cập nhật thời gian hiện tại
  let currentMinutes = Math.floor(currentTime / 60);
  let currentSeconds = Math.floor(currentTime % 60);
  currentTimeEl.textContent = `${currentMinutes}:${
    currentSeconds < 10 ? "0" : ""
  }${currentSeconds}`;
}

// Tua nhạc theo thanh tiến trình
function setProgress(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const duration = audio.duration;
  if (duration) {
    audio.currentTime = (clickX / width) * duration;
  }
}

// Thay đổi âm lượng
function setVolume(e) {
  audio.volume = e.target.value;
}

// Hàm gán sự kiện click cho các thẻ bài hát
function setupMusicCards() {
  const musicCards = document.querySelectorAll(".music-card");
  musicCards.forEach((card) => {
    card.addEventListener("click", () => {
      const clickedSongId = card.getAttribute("data-song-id");
      const newIndex = playlist.findIndex(
        (song) => song.baihat_id == clickedSongId
      );

      if (newIndex !== -1) {
        songIndex = newIndex;
        loadSong(playlist[songIndex]);
        playSong();
      }
    });
  });
}

// Gán sự kiện cho các nút điều khiển
playBtn.addEventListener("click", () => (isPlaying ? pauseSong() : playSong()));
nextBtn.addEventListener("click", nextSong);
prevBtn.addEventListener("click", prevSong);
audio.addEventListener("timeupdate", updateProgress);
audio.addEventListener("ended", nextSong);
progressContainer.addEventListener("click", setProgress);
volumeSlider.addEventListener("input", setVolume);

// Bắt đầu bằng cách lấy danh sách bài hát
fetchSongs();
