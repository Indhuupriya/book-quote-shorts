<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Book Quote Shorts</title>
<style>
body{font-family: system-ui, Arial; margin:0; display:flex; align-items:center; justify-content:center; min-height:100vh; background:#f5f5f7;}
.card{width:clamp(300px,60vw,720px); background:#fff; padding:24px; border-radius:12px; box-shadow:0 8px 30px rgba(0,0,0,0.08); position:relative; overflow:hidden;}
.quote-text{font-size:1.2rem; line-height:1.5; min-height:120px; transition:transform .4s ease, opacity .4s ease;}
.meta{margin-top:16px; color:#555; font-weight:600;}
.controls{display:flex; gap:8px; margin-top:18px; flex-wrap:wrap;}
button{padding:8px 12px;border-radius:8px;border:1px solid #ddd;background:#fff;cursor:pointer;}
button.primary{background:#111;color:#fff;border:0;}
.like.active{color:crimson;}
@media (max-width:420px){ .quote-text{font-size:1rem} .card{padding:16px} }
.fade-out{opacity:0; transform:translateY(12px);}
.fade-in{opacity:1; transform:translateY(0);}
</style>
</head>
<body>
<div class="card" id="card">
  <div id="quoteText" class="quote-text"></div>
  <div class="meta"><span id="author"></span> — <span id="book"></span></div>
  <div class="controls">
    <button id="prev">Prev</button>
    <button id="playToggle">Play</button>
    <button id="next">Next</button>
    <button id="like" class="like">♡ <span id="likesCount">0</span></button>
    <button id="share">Share</button>
  </div>
</div>

<script type="module">
const apiBase = '/api';
let quotes = [];
let idx = 0;
let autoplay = false;
let timer = null;

const el = {
  quoteText: document.getElementById('quoteText'),
  author: document.getElementById('author'),
  book: document.getElementById('book'),
  prevBtn: document.getElementById('prev'),
  nextBtn: document.getElementById('next'),
  playBtn: document.getElementById('playToggle'),
  likeBtn: document.getElementById('like'),
  likesCount: document.getElementById('likesCount'),
  shareBtn: document.getElementById('share'),
  card: document.getElementById('card')
};

async function loadQuotes() {
  try {
    const res = await fetch(`${apiBase}/quotes`);
    quotes = await res.json();
    if (quotes.length === 0) { el.quoteText.textContent = 'No quotes found.'; return; }
    renderCurrent();
  } catch (err) {
    el.quoteText.textContent = 'Failed to load quotes.';
    console.error(err);
  }
}

function renderCurrent(){
  const q = quotes[idx];
  el.quoteText.classList.add('fade-out');
  setTimeout(()=>{
    el.quoteText.textContent = q.quote;
    el.author.textContent = q.author || 'Unknown';
    el.book.textContent = q.book || '';
    el.likesCount.textContent = q.likes ?? 0;
    updateLikeState(q.id);
    el.quoteText.classList.remove('fade-out');
    el.quoteText.classList.add('fade-in');
    setTimeout(()=>el.quoteText.classList.remove('fade-in'),300);
  },150);
}

function next() { idx = (idx + 1) % quotes.length; renderCurrent(); resetAutoplayTimer(); }
function prev() { idx = (idx - 1 + quotes.length) % quotes.length; renderCurrent(); resetAutoplayTimer(); }

function startAutoplay() { autoplay = true; el.playBtn.textContent='Pause'; timer=setInterval(next,4500); }
function stopAutoplay() { autoplay = false; el.playBtn.textContent='Play'; if(timer){clearInterval(timer);timer=null;} }
function resetAutoplayTimer(){ if(autoplay){ clearInterval(timer); timer=setInterval(next,4500); } }

function getLikedSet(){ try{return new Set(JSON.parse(localStorage.getItem('liked_quotes')||'[]')); }catch(e){ return new Set(); } }
function setLikedSet(s){ localStorage.setItem('liked_quotes', JSON.stringify(Array.from(s))); }
function updateLikeState(quoteId){ el.likeBtn.classList.toggle('active', getLikedSet().has(quoteId)); }

async function likeCurrent(){
  const q = quotes[idx];
  const likedSet = getLikedSet();
  if(likedSet.has(q.id)) return;
  try {
    const res = await fetch(`${apiBase}/quotes/${q.id}/like`,{method:'POST'});
    const data = await res.json();
    q.likes = data.likes;
    el.likesCount.textContent = q.likes;
    likedSet.add(q.id);
    setLikedSet(likedSet);
    updateLikeState(q.id);
  } catch(e){ console.error(e); alert('Failed to like.'); }
}

function shareCurrent(){
  const q = quotes[idx];
  const text = `"${q.quote}" — ${q.author} (${q.book})`;
  if(navigator.share){ navigator.share({title:'Book Quote', text}); }
  else { navigator.clipboard.writeText(text).then(()=> alert('Quote copied.')); }
}

document.addEventListener('keydown', e=>{
  if(e.key==='ArrowRight') next();
  if(e.key==='ArrowLeft') prev();
  if(e.key===' '){ e.preventDefault(); autoplay?stopAutoplay():startAutoplay(); }
});

el.nextBtn.addEventListener('click', next);
el.prevBtn.addEventListener('click', prev);
el.playBtn.addEventListener('click', ()=>autoplay?stopAutoplay():startAutoplay());
el.likeBtn.addEventListener('click', likeCurrent);
el.shareBtn.addEventListener('click', shareCurrent);

loadQuotes();
</script>
</body>
</html>
