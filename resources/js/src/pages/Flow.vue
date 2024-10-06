<script setup>
import {onMounted, reactive, ref} from "vue";
import {VueFlow, useVueFlow} from "@vue-flow/core";

import {Background} from '@vue-flow/background';
import {Controls} from '@vue-flow/controls';
import {MiniMap} from '@vue-flow/minimap';

// Initials Elements
import {initialElements} from "../assets/initial-elements";

import container from "../components/container.vue";

// Manychat Copy Components.
import boxWithTitleVue from "../components/boxWithTitle.vue";
import boxWithStarter from "../components/boxWithStarter.vue";
import imageContainerVue from "../components/imageContainer.vue";
import boxWitAudioVue from "../components/boxWithAudio.vue";
import boxWitVideoVue from "../components/boxWithVideo.vue";
import boxWithFileVue from "../components/boxWithFile.vue";
import boxTemplate from "../components/boxTemplate.vue";
import boxLocation from "../components/boxWithLocation.vue";
import boxCondition from "../components/boxWithCondition.vue";
import globalMenuVue from "../components/globalMenu.vue";

/*import startingStep from "../components/startingStep.vue";
import facebookMessage from "../components/facebookMessage.vue";
import messageEditorVue from "../components/messageEditor.vue";
import messengerQuickReplyVue from "../components/messengerQuickReply.vue";
import iframeVue from "../components/iframe.vue";
import imageContainerVue from "../components/imageContainer.vue";
import simpleTextVue from "../components/simpleText.vue";*/
////////////////////////////////////////////.

import redirectorEdgeVue from "../components/redirectorEdge.vue";

// Custom Connection line and Custom Edge
import CustomConnectionLine from "../components/CustomConnectionLine.vue";
import customEdgeVue from "../components/customEdge.vue";
////////////////////////////////////////////.

// Externalise node creation process on Drop here
import {createVueNode} from "../utils/createVueNode";
////////////////////////////////////////////.

// Usage of Store Pinia
import {useStore} from "../stores/main.js";
import globalValue from "../mixins/helper.js";
const getMixinValue = globalValue();

const store = useStore();

const {
  addEdges,
  addNodes,
  onConnect,
  onPaneReady,
  project,
  setInteractive,
} = useVueFlow();

// Initialize elements values here.
// onMounted(() => {
//   elements.value = []
// })

// Methods that helps, centering the vue.
onPaneReady(({fitView}) => {
  fitView();
});
////////////////////////////////////////////.

// The dragAndDrop function that helps creating new nodes
// Just by dragging elements into the canvas.
// DragOver from the Sidebars.
const onDragOver = (event) => {
  event.preventDefault();
  if (event.dataTransfer) {
    event.dataTransfer.dropEffect = "move";
  }
};
////////////////////////////////////////////.

// The onDrop event handler that is responsible for the creation
const onDrop = (event) => {
  // console.log(event.target.parentNode);
  createVueNode(event, addNodes, project, store);
};
////////////////////////////////////////////.

// OnConnect node event, there is more work to do here.
onConnect((params) => {
  (params.type = "custom"), (params.animated = false);
  addEdges([params]);
});
////////////////////////////////////////////.

// Handling Clicked message to the message editor
// OnClick : connect message clicked to the message editor.
const onClick = (event) => {
  if (event.node.type == "facebook-message") {
    if (messageToEdit.value == event.node.id) {
      messageToEdit.value = "";
    } else {
      messageToEdit.value = event.node.id;
    }
  }
  store.messageToEdit = messageToEdit.value;
};
////////////////////////////////////////////.

// Implementation of a global key listener
let onKeyUp = (event) => {
  switch (event.key) {
    case "AltGraph":
      setInteractive(true);
      break;

      // Close the editor if Escape key is pressed
    case "Escape":
      messageToEdit.value = "";
      break;

    default:
      break;
  }
};

let onKeyDown = (event) => {
  switch (event.key) {
    case "AltGraph":
      setInteractive(false);
      break;

    default:
      break;
  }
};

onMounted(() => {
  templates();
  window.addEventListener("keydown", onKeyDown);
  window.addEventListener("keyup", onKeyUp);
});
////////////////////////////////////////////.

// Local variables and props declaration.
let messageToEdit = ref("");
const elements = ref(initialElements);
////////////////////////////////////////////.

// Removing data from the message store if delete button used
const onChange = (event) => {
  event.forEach((element) => {
    if (element.type == "remove") {
      store.layers.messages = store.layers.messages.filter((item) => {
        return item.id != element.id;
      });
    }
  });
};
async function templates() {
  let url = getMixinValue.getUrl('whatsapp-templates?flow_builder=1');
  await axios.get(url).then((response) => {
    if (response.data.success) {
      data.templates = response.data.templates;
    }
  })
}
////////////////////////////////////////////.
const data = reactive({
  opened: false,
  text : '',
  current_id : '',
  type : '',
  image : '',
  audio : '',
  video : '',
  latitude : '',
  longitude : '',
  template_id : '',
  template_variables : {},
  variables : [],
  templates: [],
  box_title: '',
});
function handleData(args) {
  let localStates = args.args.value;
  data.type = localStates.type;
  data.current_id = localStates.id;
  data.box_title = localStates.title;

  if (data.type == 'box-with-title') {
    data.text = localStates.text;
  }
  if (data.type == 'node-image') {
    data.image = localStates.image;
  }
  if (data.type == 'box-with-audio') {
    data.audio = localStates.audio;
    const audio_element = document.getElementById('audio');
    if(audio_element) {
      audio_element.src = data.audio;
    }
  }
  if (data.type == 'box-with-video') {
    data.video = localStates.video;
    const video_element = document.getElementById('video');
    if(video_element) {
      video_element.src = data.video;
    }
  }
  if (data.type == 'box-with-file') {
    data.file = localStates.file;
  }
  if (data.type == 'box-with-location') {
    data.latitude = localStates.latitude;
    data.longitude = localStates.longitude;
  }
  if (data.type == 'box-with-template') {
    data.template_id = localStates.template_id;
  }
}
async function handleFile(event, type) {
  let file = event.target.files[0];
  await uploadFile(file, type);
}
async function uploadFile(file, type) {
  let config = {
    headers: {
      'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2),
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  };
  let form_data = new FormData();
  form_data.append('file', file);
  form_data.append('id', data.current_id);
  form_data.append('type', data.type);
  let url = getMixinValue.getUrl('upload-files');
  await axios.post(url, form_data, config).then((response) => {
    if(type == 'audio') {
      data.audio = response.data.file_object.file;
      const audio_element = document.getElementById('audio');
      audio_element.src = response.data.file_object.file;
    } else if(type == 'video') {
      data.video = response.data.file_object.file;
      const video_element = document.getElementById('video');
      video_element.src = response.data.file_object.file;
    } else {
      data[type] = response.data.file_object.file;
    }
  }).catch((error) => {
  });
}
</script>

<template>
  <div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Configure <span>{{ data.box_title }}</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="form-group" v-if="data.type == 'box-with-title'">
          <label>Text</label>
          <input type="text" class="form-control" placeholder="Enter Text" v-model="data.text">
        </div>
        <div class="form-group" v-else-if="data.type == 'node-image'">
          <label>Image</label>
          <input type="file" accept="image/*" class="form-control" @change="handleFile($event, 'image')">
          <div>
            <img :src="data.image" alt="image" style="width: 100px; height: 100px">
          </div>
        </div>
        <div class="form-group" v-else-if="data.type == 'box-with-audio'">
          <label>Audio</label>
          <input type="file" accept="audio/*" class="form-control" @change="handleFile($event, 'audio')">
          <div style="margin-top: 20px" v-if="data.audio">
            <p style="margin: 0">Preview</p>
            <vue-plyr>
              <audio id="audio">
                <source :src="data.audio" type="audio/mp3">
              </audio>
            </vue-plyr>
          </div>
        </div>
        <div class="form-group" v-else-if="data.type == 'box-with-video'">
          <label>Video</label>
          <input type="file" accept="video/*" class="form-control" @change="handleFile($event, 'video')">
          <div style="margin-top: 20px" v-if="data.video">
            <p style="margin: 0">Preview</p>
            <vue-plyr>
              <video id="video">
                <source :src="data.video" type="video/mp4">
              </video>
            </vue-plyr>
          </div>
        </div>
        <div class="form-group" v-else-if="data.type == 'box-with-file'">
          <label>File</label>
          <input type="file" class="form-control" @change="handleFile($event, 'file')">
          <div style="margin-top: 20px" v-if="data.file">
            <p style="margin: 0">Preview</p>
            <iframe id="iframe" style="height: 500px"
                    :src="data.file"
            ></iframe>
          </div>
        </div>
        <div class="form-group" v-else-if="data.type == 'box-with-location'">
          <label>Latitude</label>
          <input type="text" v-model="data.latitude" class="form-control">
          <label>Longitude</label>
          <input type="text" v-model="data.longitude" class="form-control">
        </div>
        <div class="form-group" v-else-if="data.type == 'box-with-template'">
          <label>Template</label>
          <select class="form-control" v-model="data.template_id">
            <option value="">Select Template</option>
            <option v-for="(template, index) in data.templates" :key="index" :value="template.id">{{ template.category }} => {{ template.name }}</option>
          </select>
          <div v-if="data.variables.length > 0">
            <div class="form-group" v-for="(variable, index) in data.variables" :key="index">
              <label>{{ variable }}</label>
              <input type="text" v-model="data.template_variables[variable]" class="form-control">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="allTheNav">
      <div class="d-flex" style="height: 100vh">
        <globalMenuVue></globalMenuVue>
        <div class="m-1 border" id="vue_flow" oncontextmenu="return false;" style="position: relative; width: 95%">
          <VueFlow v-model="elements" class="customnodeflow" :snap-to-grid="true" :select-nodes-on-drag="true"
                   :only-render-visible-elements="true" :default-viewport="{ zoom: 0.5 }" :max-zoom="50" :min-zoom="0.05" @dragover="onDragOver"
                   @drop="onDrop"
                   @nodeDoubleClick="onClick" @nodesChange="onChange">
            <Background pattern-color="grey" gap="16" size="1.2"/>

            <!-- Custom Connection from example -->
            <template #connection-line="{ sourceX, sourceY, targetX, targetY }">
              <CustomConnectionLine :source-x="sourceX" :source-y="sourceY" :target-x="targetX" :target-y="targetY"/>
            </template>
            <!-- Custom Connection from example -->

            <!-- Custom Edge from example -->
            <template #edge-custom="props">
              <customEdgeVue v-bind="props"/>
            </template>
            <!-- Custom Edge from example -->

            <!-- Redirector used as a proxy, for returning edges -->
            <template #node-redirector="props">
              <redirectorEdgeVue v-bind="props"/>
            </template>
            <!-- Redirector used as a proxy, for returning edges -->

            <!-- Importing custom templates -->
<!--            <template #node-container="props">
              <container :id="props.id" :selected="props.selected"/>
            </template>-->
<!--            <template #node-starting-step="props">
              <startingStep :id="props.id" :selected="props.selected"/>
            </template>-->
<!--            <template #node-facebook-message="props">
              <facebookMessage :id="props.id" :selected="props.selected"/>
            </template>-->
<!--            <template #node-quick-reply="props">
              <messengerQuickReplyVue :id="props.id" :selected="props.selected"/>
            </template>-->
<!--            <template #node-free-mind="props">
              <iframeVue :id="props.id" :selected="props.selected"/>
            </template>-->
            <template #node-starter-box="props">
              <boxWithStarter @data-sent="handleData" :id="props.id" :selected="props.selected" :text="data.text" :current_id="data.current_id"/>
            </template>
            <template #node-box-with-title="props">
              <boxWithTitleVue   @data-sent="handleData" :id="props.id" :selected="props.selected" :text="data.text" :current_id="data.current_id"/>
            </template>
            <template #node-node-image="props">
              <imageContainerVue @data-sent="handleData" :id="props.id" :selected="props.selected" :image="data.image" :current_id="data.current_id"/>
            </template>

            <!--        <template #node-simple-text="props">
                      <simpleTextVue :id="props.id" :selected="props.selected" />
                    </template>-->
            <template #node-box-with-audio="props">
              <boxWitAudioVue @data-sent="handleData" :id="props.id" :selected="props.selected" :audio="data.audio" :current_id="data.current_id"/>
            </template>
            <template #node-box-with-video="props">
              <boxWitVideoVue @data-sent="handleData" :id="props.id" :selected="props.selected" :video="data.video" :current_id="data.current_id"/>
            </template>
            <template #node-box-with-file="props">
              <boxWithFileVue @data-sent="handleData" :id="props.id" :selected="props.selected" :file="data.file" :current_id="data.current_id"/>
            </template>
            <template #node-box-with-location="props">
              <boxLocation @data-sent="handleData" :id="props.id" :selected="props.selected" :latitude="data.latitude" :longitude="data.longitude" :current_id="data.current_id"/>
            </template>
            <template #node-box-with-template="props">
              <boxTemplate @data-sent="handleData" :id="props.id" :selected="props.selected" :template_id="data.template_id" :template_variables="data.template_variables" :current_id="data.current_id"/>
            </template>
            <template #node-box-with-condition="props">
              <boxCondition  :id="props.id" :selected="props.selected"/>
            </template>
            <!-- End of importing custom templates -->
            <Controls/>
            <MiniMap v-show="messageToEdit === ''"/>
          </VueFlow>
        </div>

        <!-- Message Editor extension -->
        <!--    <Transition name="fade">
              <messageEditorVue v-if="messageToEdit != ''" :id="messageToEdit"></messageEditorVue>
            </Transition>-->
        <!-- Message Editor extension -->
      </div>
    </div>
    <!-- {{ store }} -->
  </div>
</template>

