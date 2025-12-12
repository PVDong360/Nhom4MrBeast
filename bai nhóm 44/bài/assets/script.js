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
  const playerBar = document.querySelector(".player-bar"); // Lấy thanh nhạc

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

        // --- DÒNG MỚI: Hiện thanh nhạc lên ---
        playerBar.classList.add("show");
      }
    });
  });
}
// --- Xử lý nút đóng trình phát nhạc ---
const closePlayerBtn = document.getElementById("close-player-btn");
if (closePlayerBtn) {
  closePlayerBtn.addEventListener("click", () => {
    const playerBar = document.querySelector(".player-bar");
    playerBar.classList.remove("show"); // Xóa class show để nó tụt xuống lại
    pauseSong(); // Tùy chọn: Dừng nhạc khi đóng
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
/* ============================================= */
/* --- PHẦN CODE CHO TÌM KIẾM --- */
/* ============================================= */

// Lấy các phần tử HTML mới
const searchInput = document.getElementById("search-input");
const mainContent = document.getElementById("main-content");
let searchDebounceTimer = null; // Biến dùng để "debounce"

// 1. Hàm "debounce" để tránh gọi API liên tục
// Chỉ chạy tìm kiếm sau khi người dùng ngừng gõ 300ms
function debounce(func, delay) {
  clearTimeout(searchDebounceTimer);
  searchDebounceTimer = setTimeout(func, delay);
}

// 2. Hàm xử lý tìm kiếm
function handleSearch() {
  const query = searchInput.value.trim();

  // Nếu ô tìm kiếm trống, tải lại trang để hiện các kệ nhạc gốc
  if (query === "") {
    // Dùng location.reload() là cách đơn giản nhất để khôi phục nội dung gốc
    location.reload();
    return;
  }

  // Gọi hàm fetch API
  fetchSearchResults(query);
}

// 3. Hàm gọi API
async function fetchSearchResults(query) {
  try {
    // Mã hóa từ khóa để gửi qua URL
    const response = await fetch(
      `api_search.php?query=${encodeURIComponent(query)}`
    );
    const songs = await response.json();
    displaySearchResults(songs); // Gửi kết quả cho hàm hiển thị
  } catch (error) {
    console.error("Lỗi khi tìm kiếm:", error);
  }
}

// 4. Hàm hiển thị kết quả lên trang
function displaySearchResults(songs) {
  // Xóa sạch nội dung cũ (các kệ Pop, Rock...)
  mainContent.innerHTML = "";

  let html = "<h2>Kết quả tìm kiếm</h2>";

  if (songs.length === 0) {
    html += "<p>Không tìm thấy kết quả nào.</p>";
  } else {
    // Tạo lưới hiển thị (dạng danh sách, không có hình ảnh)
    html += '<div class="search-results-list">';

    // Lặp qua từng bài hát và tạo HTML
    songs.forEach((song) => {
      html += `
        <div class="search-result-item" data-song-id="${song.baihat_id}">
            <p class="result-title"><a class="result-link" href="song.php?id=${song.baihat_id}">${escapeHTML(song.ten_bai_hat)}</a></p>
            <p class="result-artist">${escapeHTML(song.ca_si)}</p>
        </div>
      `;
    });

    html += "</div>";
  }

  // Đưa HTML mới vào trang
  mainContent.innerHTML = html;

  // 5. QUAN TRỌNG: Gắn lại sự kiện click cho các thẻ bài hát MỚI
  // Vì các thẻ cũ đã bị xóa, chúng ta phải thêm lại sự kiện
  addClickListenersToNewCards();
}

// 6. Hàm thêm sự kiện click cho thẻ nhạc (tách ra từ setupMusicCards)
function addClickListenersToNewCards() {
  const newMusicCards = mainContent.querySelectorAll(".search-result-item");

  newMusicCards.forEach((card) => {
    card.addEventListener("click", (e) => {
      const clickedSongId = card.getAttribute("data-song-id");
      // Điều hướng toàn bộ thẻ tới trang chi tiết bài hát
      if (clickedSongId) {
        window.location.href = `song.php?id=${encodeURIComponent(clickedSongId)}`;
      }
    });
  });
}

// Hàm phụ trợ để tránh lỗi XSS (Cross-Site Scripting)
function escapeHTML(str) {
  return str
    .toString()
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#39;");
}

// 7. Gắn sự kiện chính vào thanh tìm kiếm
if (searchInput) {
  searchInput.addEventListener("input", () => {
    debounce(handleSearch, 300); // Gọi hàm debounce
  });
}
