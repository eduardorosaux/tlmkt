<script setup>
import { ref, computed, watch } from "vue";
import { Handle, Position } from '@vue-flow/core';

// Importing Store Pinia
import { useStore } from "../stores/main.js";

// custom Top Menu import
import topMenu from "./topMenu.vue";

// Local variables and props declaration
const transparent = ref(true);
let selectedColor = ref(false);
const props = defineProps({
  id: String,
  selected: Boolean,
});
////////////////////////////////////////////.

// Usage of Store Pinia
const store = useStore();

// Computed Values from Store.
let localStates = computed(() => {
  return store.getMessageById(props.id);
});

// Watching Selected Manual event
watch(
  () => props.selected,
  (isSelected) => (selectedColor.value = isSelected)
);
watch(() => props.text, () => {
  if (props.id === props.current_id) {
    localStates.value.text = props.text;
  }
});
const emit = defineEmits(['data-sent']);
function handleData() {
  emit('data-sent', { args : localStates });
}
////////////////////////////////////////////.
</script>

<template>
  <!-- Handle for different utilities -->
  <Handle id="right" class="handle" type="source" :position="Position.Right" style="top: 60%" />
  <Handle id="false" class="handle" type="source" :position="Position.Right" style="top: 75%" />
  <Handle id="left" class="handle" type="target" :position="Position.Left" />
  <!--  <Handle
      id="bottom"
      class="handle"
      type="source"
      :position="Position.Bottom"
      style="top: 100%;right: 150%"
    />-->
  <!-- Handle for different utilities -->

  <div
    @mouseenter="transparent = false"
    @mouseleave="transparent = true"
    class="d-flex flex-column align-items-center"
  >
    <!-- Delete Button and color controls -->
    <topMenu :eid="props.id" :transparent="transparent"></topMenu>
    <!-- Delete Button and color controls -->

    <div
      class="main-container"
      :style="{
        border: selectedColor
          ? '3px red solid'
          : `3px ${localStates.color} solid`,
      }"
    >

      <div class="content">
        <div class="card" style="width: 18rem;">
          <div class="card-body" style="padding-left: 10px;padding-bottom: 0">
            <p class="card-title">Condition</p>
            <div style="text-align: right;margin-top: 20px">
              <p style="margin: 0">True</p>
              <p>False</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
