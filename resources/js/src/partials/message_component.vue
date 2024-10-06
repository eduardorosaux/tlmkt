<script setup>

</script>

<template>
  <div class="single-sp-chat-area single-sp-img-box text-end mt--70">
    <a href="assets/images/chat-page/chat-img.png" class="image-link">
      <img :src="getMixinValue.assetUrl('client/chat-page/chat-author-01.png')" alt="Image">
    </a>
    <a href="assets/images/chat-page/chat-img-2.png" class="image-link">
      <img :src="getMixinValue.assetUrl('client/chat-page/chat-author-01.png')" alt="Image">
    </a>
    <a href="assets/images/chat-page/chat-img-3.png" class="image-link">
      <img :src="getMixinValue.assetUrl('client/chat-page/chat-author-01.png')" alt="Image">
    </a>
  </div>

  <div class="single-sp-chat-area single-sp-audio-box text-end mt--23">
    <audio controls id="audioPlayer" class="plyr">
      <source :src="getMixinValue.assetUrl('client/chat-page/chat-author-01.png')" type="audio/mp3">
    </audio>
    <span class="chat-time-text mr--10">11:52 AM</span>
  </div>

  <div class="single-sp-chat-area single-sp-card-box text-end mt--23">
    <div class="single-sp-card">
      <div class="sp-card-img">
        <img :src="getMixinValue.assetUrl('client/chat-page/chat-author-01.png')" alt="Card Image">
      </div>
      <div class="card-content">
        <h6 class="title">50% OFF | Winter Sale 2024</h6>
        <p class="desc">❄️Enjoy 50% Off on Premium Scripts, Apps & Addons ❄️ ⚡Flat 50% OFF!! Only for You!
          Grab the Coolest deals now, Flat 50% off on our all Products </p>
        <p class="bottom-text">Thanks for staying with SpaGreen Creative</p>
        <a href="#" class="card-btn">Get Offer Now</a>
      </div>
    </div>
  </div>

  <div class="single-sp-chat-area single-sp-card-box text-end mt--23">
    <div class="single-sp-card">
      <div class="sp-card-img has-vedio-icon">
        <img :src="getMixinValue.assetUrl('client/chat-page/chat-author-01.png')" alt="Card Image">
        <a href="https://www.youtube.com/watch?v=tj9-MGHCs38" class="vedio-player-btn popup-video">
          <i class="las la-play-circle"></i>
        </a>
      </div>
      <div class="card-content">
        <h6 class="title">50% OFF | Winter Sale 2024</h6>
        <p class="desc">❄️Enjoy 50% Off on Premium Scripts, Apps & Addons ❄️ ⚡Flat 50% OFF!! Only for You!
          Grab the Coolest deals now, Flat 50% off on our all Products </p>
        <p class="bottom-text">Thanks for staying with SpaGreen Creative</p>
        <a href="#" class="card-btn card-btn-border">Visit Website</a>
        <a href="#" class="card-btn">Get Offer Now</a>
      </div>
    </div>
    <span class="chat-time-text mr--10">11:52 AM</span>
  </div>

  <div class="single-sp-chat-area single-sp-card-box text-end mt--23">
    <div class="single-sp-card">
      <div class="card-content">
        <h6 class="title">50% OFF | Winter Sale 2024</h6>
        <p class="desc">❄️Enjoy 50% Off on Premium Scripts, Apps & Addons ❄️ ⚡Flat 50% OFF!! Only for You!
          Grab the Coolest deals now, Flat 50% off on our all Products </p>
        <p class="bottom-text">Thanks for staying with SpaGreen Creative</p>
        <a href="#" class="card-btn">Get Offer Now</a>
      </div>
    </div>
  </div>

  <div class="single-sp-chat-area single-sp-card-box text-end mt--23">
    <div class="single-sp-card">
      <div class="card-content">
        <h6 class="title">50% OFF | Winter Sale 2024</h6>
        <p class="desc">❄️Enjoy 50% Off on Premium Scripts, Apps & Addons ❄️ ⚡Flat 50% OFF!! Only for You!
          Grab the Coolest deals now, Flat 50% off on our all Products </p>
        <p class="bottom-text">Thanks for staying with SpaGreen Creative</p>
      </div>
    </div>
    <span class="chat-time-text mr--10">11:52 AM</span>
  </div>

  <div class="single-sp-chat-area single-sp-card-box d-flex mt--23">
    <div class="single-sp-card sp-info-card">
      <div class="sp-info-card-img">
        <img :src="getMixinValue.assetUrl('client/chat-page/chat-author-01.png')" alt="Card Image">
      </div>
      <div class="card-content text-center">
        <h6 class="title">Marina Jolly</h6>
        <p class="info"><i class="lab la-whatsapp"></i>+8801400620055</p>
        <a href="#" class="card-btn">Chat</a>
      </div>
    </div>
    <span class="chat-time-text ml--10">11:52 AM</span>
  </div>

  <div class="single-sp-chat-area single-sp-card-box mt--23">
    <div class="chat-map-card">
      <div class="map-area">
        <div id="map"></div>
        <div class="meta-title"><i class="las la-map-marker-alt"></i>Live untill 12:19 PM</div>
      </div>
      <div class="card-content">
        <a href="#" class="card-btn">View Live Location</a>
      </div>
    </div>
  </div>

  <div class="single-sp-chat-area single-sp-card-box text-end  mt--23">
    <div class="chat-map-card">
      <a href="#">
        <div class="map-area">
          <div id="map2" style="height: 195px; width: 100%;"></div>
        </div>
        <div class="meta-caption">
          <h6 class="title">Mirpur DOHS Lake Park</h6>
          <p>Mirpur DOHS, Dhaka, Dhaka Division - 1216</p>
        </div>
      </a>
    </div>
  </div>

  <div class="single-sp-chat-area single-sp-card-box text-end mt--23">
    <div class="single-sp-card sp-document-card">
      <div class="card-content mt--0">
        <div class="document-part">
          <div class="icon">
            <i class="las la-file-alt"></i>
          </div>
          <div class="info-part">
            <h6 class="title">Documentation.zip</h6>
            <p>511 KB, zip File</p>
          </div>
        </div>
        <a href="#" class="card-btn">Download</a>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>