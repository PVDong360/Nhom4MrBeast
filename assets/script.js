/* ====================================================== */
/* FILE: assets/script.js (CẤU TRÚC CŨ + TÍNH NĂNG MỚI)   */
/* ====================================================== */

// --- 1. KHAI BÁO BIẾN (GIỮ NGUYÊN) ---
const audio = document.getElementById("audio");
const playBtn = document.getElementById("play-btn");
const prevBtn = document.getElementById("prev-btn");
const nextBtn = document.getElementById("next-btn");
const progress = document.getElementById("progress");
const progressContainer = document.getElementById("progress-container");
const songTitleEl = document.getElementById("song-title");
const songArtistEl = document.getElementById("song-artist");
const songArtworkEl = document.getElementById("song-artwork");
const currentTimeEl = document.getElementById("current-time");
const totalDurationEl = document.getElementById("total-duration");
const volumeSlider = document.querySelector(".volume-slider");
const likeBtn = document.getElementById("like-btn");

// Nút chức năng mới
const shuffleBtn = document.getElementById("shuffle-btn");
const repeatBtn =
  document.querySelector(".fa-repeat") || document.getElementById("repeat-btn");

// Biến trạng thái
let songIndex = 0;
let isPlaying = false;
let playlist = [];
let currentSongIdForLike = null;
let currentPlaylistId = null;

// [MỚI] Cấu hình Shuffle & Repeat
let isShuffle = false;
let repeatMode = 1; // 0: Tắt, 1: Lặp danh sách, 2: Lặp 1 bài

// --- 2. HÀM PLAYER CƠ BẢN (GIỮ NGUYÊN) ---

function loadSong(song) {
  songTitleEl.innerText = song.ten_bai_hat;
  songArtistEl.innerText = song.ca_si;
  songArtworkEl.src = song.hinh_anh;
  if (song.file_mp3.includes("/")) {
    audio.src = song.file_mp3;
  } else {
    audio.src = "uploads/music/" + song.file_mp3;
  }

  checkLikeStatus(song.baihat_id);
  currentSongIdForLike = song.baihat_id;

  // Cập nhật giao diện danh sách phát (để highlight bài đang hát)
  renderQueue();
}

function playSong() {
  isPlaying = true;
  if (playBtn) {
    playBtn.classList.remove("fa-circle-play");
    playBtn.classList.add("fa-circle-pause");
  }
  if (audio) audio.play();
}

function pauseSong() {
  isPlaying = false;
  if (playBtn) {
    playBtn.classList.remove("fa-circle-pause");
    playBtn.classList.add("fa-circle-play");
  }
  if (audio) audio.pause();
}

// --- 3. [MỚI] LOGIC NEXT/PREV (CẬP NHẬT TRỘN & LẶP) ---

function nextSong() {
  if (playlist.length === 0) return;

  // Ưu tiên: Nếu đang Repeat 1 bài -> Tua lại đầu
  if (repeatMode === 2) {
    audio.currentTime = 0;
    playSong();
    return;
  }

  // Nếu đang bật Shuffle -> Chọn bài ngẫu nhiên
  if (isShuffle) {
    let newIndex;
    do {
      newIndex = Math.floor(Math.random() * playlist.length);
    } while (newIndex === songIndex && playlist.length > 1);
    songIndex = newIndex;
  } else {
    // Chế độ bình thường
    songIndex++;
    if (songIndex >= playlist.length) {
      if (repeatMode === 1) songIndex = 0; // Loop All
      else {
        pauseSong();
        return;
      } // Dừng khi hết
    }
  }
  loadSong(playlist[songIndex]);
  playSong();
}

function prevSong() {
  if (playlist.length === 0) return;

  if (audio.currentTime > 5) {
    audio.currentTime = 0; // Tua lại đầu bài
  } else {
    if (isShuffle) {
      let newIndex;
      do {
        newIndex = Math.floor(Math.random() * playlist.length);
      } while (newIndex === songIndex && playlist.length > 1);
      songIndex = newIndex;
    } else {
      songIndex--;
      if (songIndex < 0) songIndex = playlist.length - 1;
    }
    loadSong(playlist[songIndex]);
  }
  playSong();
}

// --- 4. [MỚI] XỬ LÝ SỰ KIỆN KÉO THẢ (DRAG & DROP) ---
let dragStartIndex;

function addDragAndDropListeners() {
  const draggables = document.querySelectorAll(".queue-item");
  draggables.forEach((draggable) => {
    draggable.addEventListener("dragstart", dragStart);
    draggable.addEventListener("dragover", dragOver);
    draggable.addEventListener("drop", dragDrop);
    draggable.addEventListener("dragenter", dragEnter);
    draggable.addEventListener("dragleave", dragLeave);
  });
}

function dragStart() {
  dragStartIndex = +this.getAttribute("data-index");
  this.classList.add("dragging");
}
function dragEnter(e) {
  e.preventDefault();
  this.classList.add("over");
}
function dragLeave() {
  this.classList.remove("over");
}
function dragOver(e) {
  e.preventDefault();
}
function dragDrop() {
  const dragEndIndex = +this.getAttribute("data-index");
  swapItems(dragStartIndex, dragEndIndex);
  this.classList.remove("over");
  document
    .querySelectorAll(".dragging")
    .forEach((el) => el.classList.remove("dragging"));
}

function swapItems(fromIndex, toIndex) {
  const currentPlayingSong = playlist[songIndex]; // Lưu bài đang hát

  // Cắt và chèn vị trí mới
  const itemToMove = playlist.splice(fromIndex, 1)[0];
  playlist.splice(toIndex, 0, itemToMove);

  // Cập nhật lại songIndex để player không bị loạn
  songIndex = playlist.findIndex((song) => song === currentPlayingSong);

  renderQueue(); // Vẽ lại danh sách
}

// --- 5. [MỚI] RENDER DANH SÁCH (CÓ KÉO THẢ) ---

const queueBtn = document.getElementById("queue-btn");
const queuePopup = document.getElementById("queue-popup");
const queueListEl = document.getElementById("queue-list");

if (queueBtn && queuePopup) {
  queueBtn.addEventListener("click", () => {
    if (queuePopup.style.display === "flex") {
      queuePopup.style.display = "none";
      queueBtn.style.color = "inherit";
    } else {
      queuePopup.style.display = "flex";
      queueBtn.style.color = "#1DB954";
      renderQueue();
    }
  });
  // Đóng khi click ra ngoài
  document.addEventListener("click", (e) => {
    if (!queuePopup.contains(e.target) && e.target !== queueBtn) {
      queuePopup.style.display = "none";
      queueBtn.style.color = "inherit";
    }
  });
}

function renderQueue() {
  if (!queueListEl) return;
  queueListEl.innerHTML = "";

  if (playlist.length === 0) {
    queueListEl.innerHTML =
      '<p style="color:#aaa; padding:10px;">Danh sách trống.</p>';
    return;
  }

  playlist.forEach((song, index) => {
    const isActive = index === songIndex ? "active" : "";
    const imgSrc = song.hinh_anh
      ? song.hinh_anh
      : "uploads/images/default_song.jpg";

    const div = document.createElement("div");
    div.className = `queue-item ${isActive}`;
    // Thêm thuộc tính cho Drag & Drop
    div.setAttribute("draggable", "true");
    div.setAttribute("data-index", index);

    div.style.cssText =
      "display:flex; align-items:center; padding:8px; border-bottom:1px solid #333; transition:background 0.2s; cursor: grab;";
    if (isActive) div.style.background = "#333";

    div.innerHTML = `
            <i class="fa-solid fa-grip-vertical" style="color:#555; margin-right:10px; cursor: grab;"></i>
            <div style="display:flex; align-items:center; flex-grow:1; cursor:pointer;" onclick="playQueueIndex(${index})">
                <img src="${imgSrc}" style="width:40px; height:40px; border-radius:4px; margin-right:10px; object-fit:cover;">
                <div>
                    <p style="margin:0; font-size:14px; color:${
                      isActive ? "#1DB954" : "white"
                    }; font-weight:500;">${song.ten_bai_hat}</p>
                    <p style="margin:0; font-size:12px; color:#aaa;">${
                      song.ca_si
                    }</p>
                </div>
            </div>
        `;
    queueListEl.appendChild(div);
  });

  addDragAndDropListeners(); // Kích hoạt sự kiện kéo thả

  const activeItem = queueListEl.querySelector(".active");
  if (activeItem)
    activeItem.scrollIntoView({ behavior: "smooth", block: "center" });
}

function playQueueIndex(index) {
  songIndex = index;
  loadSong(playlist[songIndex]);
  playSong();
}

// --- 6. XỬ LÝ NÚT SHUFFLE & REPEAT ---

if (shuffleBtn) {
  shuffleBtn.addEventListener("click", () => {
    isShuffle = !isShuffle;
    shuffleBtn.style.color = isShuffle ? "#1DB954" : "inherit";
    if (isShuffle && repeatMode === 2) {
      repeatMode = 1;
      updateRepeatButton();
    }
  });
}

if (repeatBtn) {
  updateRepeatButton();
  repeatBtn.addEventListener("click", () => {
    if (repeatMode === 1) repeatMode = 2;
    else if (repeatMode === 2) repeatMode = 0;
    else repeatMode = 1;
    updateRepeatButton();
  });
}

function updateRepeatButton() {
  if (!repeatBtn) return;
  repeatBtn.innerHTML = "";
  repeatBtn.style.position = "static";

  if (repeatMode === 0) {
    repeatBtn.style.color = "inherit";
    repeatBtn.title = "Không lặp";
  } else if (repeatMode === 1) {
    repeatBtn.style.color = "#1DB954";
    repeatBtn.title = "Lặp danh sách";
  } else if (repeatMode === 2) {
    repeatBtn.style.color = "#1DB954";
    repeatBtn.title = "Lặp 1 bài";
    repeatBtn.innerHTML =
      '<span style="font-size:8px; position:absolute; top:8px; right:-3px; background:#181818; padding:0 2px;">1</span>';
    repeatBtn.style.position = "relative";
  }
}

// Trang chủ
async function fetchSongs() {
  try {
    const response = await fetch("api_get_songs.php");
    const songs = await response.json();
    if (playlist.length === 0) playlist = songs;
    setupMusicCards();
  } catch (e) {
    console.error("Lỗi fetchSongs:", e);
  }
}

// Nhạc yêu thích (Đã thêm kiểm tra đăng nhập)
async function fetchLikedSongs() {
  const container = document.getElementById("liked-songs-container");
  if (!container) return;
  container.innerHTML =
    '<p style="color:white; margin-top:20px;">Đang tải...</p>';

  try {
    const res = await fetch("api_get_liked_songs.php");
    const data = await res.json();

    // [MỚI] Kiểm tra đăng nhập
    if (data.status === "error") {
      container.innerHTML = `<p style="color:#aaa; margin-top:20px;">Vui lòng đăng nhập để xem.</p>`;
      return;
    }

    const songs = data;
    container.innerHTML = "";
    if (songs.length === 0) {
      container.innerHTML = '<p style="color:#aaa;">Chưa thích bài nào.</p>';
      return;
    }

    // Render danh sách (Code cũ)
    let html =
      '<div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px;">';
    songs.forEach((song) => {
      html += `<div class="music-card liked-card" data-id="${song.baihat_id}">
                        <img src="${
                          song.hinh_anh || "uploads/images/default_song.jpg"
                        }" style="width:100%; aspect-ratio:1/1; object-fit:cover; border-radius:8px;">
                        <p class="card-title" style="color:white; font-weight:bold;">${
                          song.ten_bai_hat
                        }</p>
                        <p class="card-artist" style="color:#aaa;">${
                          song.ca_si
                        }</p>
                     </div>`;
    });
    html += "</div>";
    container.innerHTML = html;
    container.querySelectorAll(".liked-card").forEach((card) => {
      card.addEventListener("click", () => {
        playlist = songs;
        playSongById(card.getAttribute("data-id"), playlist);
        document.querySelector(".player-bar").classList.add("show");
      });
    });
  } catch (e) {
    container.innerHTML = "<p>Lỗi tải.</p>";
  }
}

// Danh sách phát (Đã thêm kiểm tra đăng nhập)
async function fetchPlaylists() {
  const container = document.getElementById("playlist-container");
  if (!container) return;
  container.innerHTML = '<p style="color:white;">Đang tải...</p>';

  try {
    const res = await fetch("api_get_playlists.php");
    const data = await res.json();

    // [MỚI] Kiểm tra đăng nhập
    if (data.status === "error") {
      container.innerHTML = `<p style="color:#aaa;">Vui lòng đăng nhập.</p>`;
      return;
    }

    const playlists = data;
    container.innerHTML = "";
    if (playlists.length === 0) {
      container.innerHTML = '<p style="color:#aaa;">Chưa có playlist.</p>';
      return;
    }

    // Render playlist (Code cũ)
    let html =
      '<div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px;">';
    playlists.forEach((pl) => {
      html += `<div class="music-card playlist-card" data-id="${pl.playlist_id}" data-name="${pl.ten_playlist}" style="background:#282828; padding:15px; border-radius:8px; cursor:pointer;">
                        <div style="width:100%; aspect-ratio:1/1; background:#333; display:flex; align-items:center; justify-content:center; border-radius:4px; margin-bottom:10px;"><i class="fa-solid fa-music" style="font-size:40px; color:#aaa;"></i></div>
                        <p class="card-title" style="color:white; font-weight:bold;">${pl.ten_playlist}</p>
                     </div>`;
    });
    html += "</div>";
    container.innerHTML = html;
    container.querySelectorAll(".playlist-card").forEach((card) => {
      card.addEventListener("click", () =>
        viewPlaylistDetails(
          card.getAttribute("data-id"),
          card.getAttribute("data-name")
        )
      );
    });
  } catch (e) {
    container.innerHTML = "<p>Lỗi tải.</p>";
  }
}

// Chi tiết Playlist
async function viewPlaylistDetails(id, name) {
  currentPlaylistId = id;
  const viewList = document.getElementById("playlists-view");
  const viewDetail = document.getElementById("playlist-detail-view");
  const title = document.getElementById("detail-playlist-name");
  const container = document.getElementById("detail-songs-container");

  if (viewList && viewDetail) {
    viewList.style.display = "none";
    viewDetail.style.display = "block";
    if (title) title.innerText = name;
    if (container) {
      container.innerHTML = "<p>Đang tải...</p>";
      try {
        const res = await fetch(`api_get_playlist_songs.php?playlist_id=${id}`);
        const songs = await res.json();
        container.innerHTML = "";
        if (songs.length === 0)
          container.innerHTML = '<p style="color:#aaa;">Trống.</p>';
        else {
          let html =
            '<div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px;">';
          songs.forEach((song) => {
            html += `<div class="music-card detail-card" data-id="${
              song.baihat_id
            }">
                                    <img src="${
                                      song.hinh_anh ||
                                      "uploads/images/default_song.jpg"
                                    }" style="width:100%; aspect-ratio:1/1; object-fit:cover; border-radius:8px;">
                                    <p class="card-title" style="color:white; font-weight:bold;">${
                                      song.ten_bai_hat
                                    }</p>
                                    <p class="card-artist" style="color:#aaa;">${
                                      song.ca_si
                                    }</p>
                                 </div>`;
          });
          html += "</div>";
          container.innerHTML = html;
          container.querySelectorAll(".detail-card").forEach((card) => {
            card.addEventListener("click", () => {
              playlist = songs;
              playSongById(card.getAttribute("data-id"), playlist);
              document.querySelector(".player-bar").classList.add("show");
            });
          });
        }
      } catch (e) {
        console.error(e);
      }
    }
  }
}

// --- 8. CÁC HÀM HỖ TRỢ KHÁC (GIỮ NGUYÊN) ---

function setupMusicCards() {
  const cards = document.querySelectorAll(".music-card");
  const playerBar = document.querySelector(".player-bar");
  cards.forEach((card) => {
    card.addEventListener("click", () => {
      const id = card.getAttribute("data-song-id");
      playSongById(id, playlist);
      if (playerBar) playerBar.classList.add("show");
    });
  });
}

function playSongById(id, songList) {
  const index = songList.findIndex((s) => s.baihat_id == id);
  if (index !== -1) {
    playlist = songList;
    songIndex = index;
    loadSong(playlist[songIndex]);
    playSong();
  }
}

async function checkLikeStatus(songId) {
  if (!likeBtn) return;
  likeBtn.className = "fa-regular fa-heart";
  likeBtn.style.color = "var(--color-secondary-text)";
  try {
    const res = await fetch(
      `api_favorite.php?action=check&baihat_id=${songId}`
    );
    const data = await res.json();
    if (data.status === "success" && data.liked) {
      likeBtn.className = "fa-solid fa-heart";
      likeBtn.style.color = "#1DB954";
    }
  } catch (e) {
    console.error(e);
  }
}

if (likeBtn) {
  likeBtn.addEventListener("click", async () => {
    if (!currentSongIdForLike) return alert("Chọn bài hát trước!");
    try {
      const res = await fetch(
        `api_favorite.php?action=toggle&baihat_id=${currentSongIdForLike}`
      );
      const data = await res.json();
      if (data.status === "success") {
        checkLikeStatus(currentSongIdForLike);
        if (document.getElementById("liked-songs-container")) fetchLikedSongs();
      } else {
        alert(data.message);
      }
    } catch (e) {
      console.error(e);
    }
  });
}

// Xử lý nút Tạo Playlist
const createBtn = document.getElementById("confirm-create");
if (createBtn) {
  createBtn.onclick = async () => {
    const input = document.getElementById("new-playlist-name");
    const name = input.value.trim();
    if (!name) return alert("Nhập tên!");
    try {
      const res = await fetch("api_create_playlist.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name: name }),
      });
      const data = await res.json();
      if (data.status === "success") {
        document.getElementById("create-modal").style.display = "none";
        fetchPlaylists();
      } else alert(data.message);
    } catch (e) {
      console.error(e);
    }
  };
}
const openCreateBtn = document.getElementById("open-create-modal");
if (openCreateBtn)
  openCreateBtn.onclick = () => {
    document.getElementById("create-modal").style.display = "flex";
  };
const cancelCreateBtn = document.getElementById("cancel-create");
if (cancelCreateBtn)
  cancelCreateBtn.onclick = () => {
    document.getElementById("create-modal").style.display = "none";
  };

// --- 9. SỰ KIỆN & KHỞI TẠO (GIỮ NGUYÊN) ---

if (playBtn)
  playBtn.addEventListener("click", () =>
    isPlaying ? pauseSong() : playSong()
  );
if (nextBtn) nextBtn.addEventListener("click", nextSong);
if (prevBtn) prevBtn.addEventListener("click", prevSong);
if (audio) {
  audio.addEventListener("timeupdate", updateProgress);
  audio.addEventListener("ended", nextSong);
}
if (progressContainer) progressContainer.addEventListener("click", setProgress);

// Tiến trình
function updateProgress(e) {
  const { duration, currentTime } = e.srcElement;
  if (isNaN(duration)) return;
  const progressPercent = (currentTime / duration) * 100;
  if (progress) progress.style.width = `${progressPercent}%`;
  if (totalDurationEl) totalDurationEl.innerText = formatTime(duration);
  if (currentTimeEl) currentTimeEl.innerText = formatTime(currentTime);
}
function formatTime(seconds) {
  const min = Math.floor(seconds / 60);
  const sec = Math.floor(seconds % 60);
  return `${min}:${sec < 10 ? "0" : ""}${sec}`;
}
function setProgress(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const duration = audio.duration;
  if (audio) audio.currentTime = (clickX / width) * duration;
}
if (volumeSlider)
  volumeSlider.addEventListener("input", (e) => {
    audio.volume = e.target.value;
  });

// CHẠY HÀM TẢI DỮ LIỆU
fetchSongs();
if (typeof fetchLikedSongs === "function") fetchLikedSongs();
if (typeof fetchPlaylists === "function") fetchPlaylists();
if (
  typeof fetchHistory === "function" &&
  document.getElementById("history-container")
)
  fetchHistory();
/* ============================================= */
/* --- KHÔI PHỤC: TÍNH NĂNG THÊM BÀI VÀO PLAYLIST --- */
/* ============================================= */

const addSongToPlaylistBtn = document.getElementById("add-song-btn");

// 1. Bắt sự kiện click nút "Thêm bài hát"
if (addSongToPlaylistBtn) {
  addSongToPlaylistBtn.addEventListener("click", () => {
    // Kiểm tra xem đã chọn playlist nào chưa
    if (!currentPlaylistId) return alert("Vui lòng chọn Playlist trước!");

    const modal = document.getElementById("add-song-modal");
    if (modal) {
      modal.style.display = "flex";
      renderSongSelector(); // Tải danh sách bài hát để chọn
    } else {
      alert(
        "Thiếu HTML modal 'add-song-modal'. Hãy kiểm tra lại file giao diện."
      );
    }
  });
}

// 2. Hàm vẽ danh sách bài hát vào trong Modal chọn
async function renderSongSelector() {
  const listContainer = document.getElementById("song-select-list");
  if (!listContainer) return;

  listContainer.innerHTML =
    '<p style="padding:10px;">Đang tải danh sách...</p>';

  try {
    // Gọi API lấy tất cả bài hát
    const res = await fetch("api_get_songs.php");
    const songs = await res.json();

    listContainer.innerHTML = "";

    if (songs.length === 0) {
      listContainer.innerHTML =
        '<p style="padding:10px;">Chưa có bài hát nào.</p>';
      return;
    }

    songs.forEach((song) => {
      const imgSrc = song.hinh_anh
        ? song.hinh_anh
        : "uploads/images/default_song.jpg";

      const div = document.createElement("div");
      div.className = "song-select-item";
      // CSS trực tiếp để đảm bảo đẹp
      div.style.cssText =
        "display:flex; align-items:center; padding:10px; border-bottom:1px solid #333; cursor:pointer; transition:0.2s;";

      div.innerHTML = `
                <img src="${imgSrc}" style="width:40px; height:40px; border-radius:4px; margin-right:10px; object-fit:cover;">
                <div style="flex-grow:1;">
                    <p style="margin:0; font-size:14px; color:white;">${song.ten_bai_hat}</p>
                    <p style="margin:0; font-size:12px; color:#aaa;">${song.ca_si}</p>
                </div>
                <button style="background:transparent; border:1px solid #1DB954; color:#1DB954; border-radius:50%; width:30px; height:30px; cursor:pointer; font-size:16px;">+</button>
            `;

      // Click vào thì gọi API thêm
      div.onclick = () => addSongToPlaylistApi(song.baihat_id);

      // Hiệu ứng hover
      div.onmouseover = () => {
        div.style.background = "#333";
      };
      div.onmouseout = () => {
        div.style.background = "transparent";
      };

      listContainer.appendChild(div);
    });
  } catch (e) {
    console.error(e);
    listContainer.innerHTML =
      '<p style="color:red; padding:10px;">Lỗi tải danh sách.</p>';
  }
}

// 3. Hàm gọi API để lưu vào Database
async function addSongToPlaylistApi(baihatId) {
  if (!currentPlaylistId) return;

  try {
    const res = await fetch("api_add_song_to_playlist.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        playlist_id: currentPlaylistId,
        baihat_id: baihatId,
      }),
    });
    const data = await res.json();

    if (data.status === "success") {
      alert("✅ Đã thêm bài hát vào Playlist!");

      // Đóng modal
      const modal = document.getElementById("add-song-modal");
      if (modal) modal.style.display = "none";

      // Tải lại nội dung Playlist để thấy bài mới
      const nameEl = document.getElementById("detail-playlist-name");
      viewPlaylistDetails(currentPlaylistId, nameEl ? nameEl.innerText : "");
    } else {
      alert("❌ " + data.message);
    }
  } catch (e) {
    console.error(e);
    alert("Lỗi kết nối server.");
  }
}

// 4. Tìm kiếm trong Modal chọn bài (Nếu có ô input id="search-song-input")
const searchSongInput = document.getElementById("search-song-input");
if (searchSongInput) {
  searchSongInput.addEventListener("input", (e) => {
    const keyword = e.target.value.toLowerCase();
    const items = document.querySelectorAll(".song-select-item");

    items.forEach((item) => {
      const text = item.innerText.toLowerCase();
      item.style.display = text.includes(keyword) ? "flex" : "none";
    });
  });
}

// 5. Đóng Modal khi bấm ra ngoài
window.addEventListener("click", (e) => {
  const modal = document.getElementById("add-song-modal");
  if (e.target == modal) {
    modal.style.display = "none";
  }
});
/* ============================================= */
/* --- CODE XỬ LÝ LỊCH SỬ NGHE NHẠC --- */
/* ============================================= */

// 1. Hàm lưu lịch sử (Gửi ngầm, không cần chờ phản hồi)
function recordHistory(baihatId) {
  const formData = new FormData();
  formData.append("baihat_id", baihatId);
  // Gọi API lưu, không cần await để tránh lag nhạc
  fetch("api_record_history.php", { method: "POST", body: formData });
}

// 2. CẬP NHẬT: Tìm hàm loadSong CŨ của bạn và THAY THẾ bằng hàm này
// (Hoặc bạn tự tìm hàm loadSong cũ và thêm dòng recordHistory vào cuối hàm)
const oldLoadSong = loadSong; // Lưu hàm cũ lại (nếu cần tham khảo)

loadSong = function (song) {
  if (!song) return;

  // --- Các dòng code hiển thị thông tin cũ ---
  if (songTitleEl) songTitleEl.innerText = song.ten_bai_hat;
  if (songArtistEl) songArtistEl.innerText = song.ca_si;
  if (songArtworkEl)
    songArtworkEl.src = song.hinh_anh
      ? song.hinh_anh
      : "uploads/images/default_song.jpg";
  if (audio) audio.src = song.file_mp3;

  checkLikeStatus(song.baihat_id);
  currentSongIdForLike = song.baihat_id;
  renderQueue();

  // --- [MỚI] GHI LẠI LỊCH SỬ ---
  recordHistory(song.baihat_id);
};

// 3. Hàm lấy và hiển thị lịch sử (Cho trang Lịch sử nghe)
async function fetchHistory() {
  const container = document.getElementById("history-container");
  if (!container) return; // Nếu không ở trang lịch sử thì thoát

  container.innerHTML =
    '<p style="color:white; margin-top:20px;">Đang tải...</p>';
  try {
    const res = await fetch("api_get_history.php");
    const data = await res.json();

    // Kiểm tra đăng nhập
    if (data.status === "error") {
      container.innerHTML =
        '<p style="color:#aaa;">Vui lòng đăng nhập để xem lịch sử.</p>';
      return;
    }

    const songs = data;
    container.innerHTML = "";

    if (!songs || songs.length === 0) {
      container.innerHTML =
        '<p style="color:#aaa;">Bạn chưa nghe bài hát nào.</p>';
      return;
    }

    // Vẽ danh sách lịch sử
    let html =
      '<div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px; margin-top: 20px;">';
    songs.forEach((song) => {
      // Định dạng thời gian
      const timeStr = new Date(song.thoi_gian).toLocaleString();

      html += `
                <div class="music-card history-item" data-id="${
                  song.baihat_id
                }" style="cursor: pointer; position:relative;">
                    <img src="${
                      song.hinh_anh || "uploads/images/default_song.jpg"
                    }" style="width:100%; aspect-ratio:1/1; object-fit:cover; border-radius:8px; margin-bottom:10px;">
                    <p class="card-title" style="font-weight:bold; color:white;">${
                      song.ten_bai_hat
                    }</p>
                    <p class="card-artist" style="font-size:0.9em; color:#aaa;">${
                      song.ca_si
                    }</p>
                    <p style="font-size:0.7em; color:#555; margin-top:5px;">${timeStr}</p>
                </div>`;
    });
    html += "</div>";
    container.innerHTML = html;

    // Click vào để nghe lại
    container.querySelectorAll(".history-item").forEach((card) => {
      card.addEventListener("click", () => {
        // Khi bấm vào lịch sử, ta tạo một playlist tạm thời từ lịch sử đó
        playlist = songs;
        // Tìm vị trí bài hát vừa click (lấy index của thẻ div)
        const clickIndex = Array.from(card.parentNode.children).indexOf(card);
        songIndex = clickIndex;

        loadSong(playlist[songIndex]);
        playSong();
        const playerBar = document.querySelector(".player-bar");
        if (playerBar) playerBar.classList.add("show");
      });
    });
  } catch (e) {
    console.error(e);
    container.innerHTML = '<p style="color:red;">Lỗi tải dữ liệu.</p>';
  }
}

// Gọi hàm fetchHistory khi tải trang (Nếu đang ở trang lịch sử)
if (document.getElementById("history-container")) {
  fetchHistory();
}
