<script setup>
const props = defineProps({
	type: String,
	title: String,
	subtitle: String,
	logoColor: String,
	logoComponent: Object,
});

const {
	type,
	title,
	subtitle,
	logoColor,
	logoComponent
} = props;

const onDragStart = ($event) => {
	if ($event.dataTransfer) {
		$event.dataTransfer.setData("application/vueflow", type);
		$event.dataTransfer.effectAllowed = "move";
	}
};
</script>

<template>
	<div class="element-dragable vue-flow__node-output m-1" :draggable="true" @dragstart="onDragStart">
		<div class="d-flex align-items-center">
			<div class="Logo" :style="{ backgroundColor: logoColor }">
				<component :is="logoComponent" />
			</div>
			<div style="width: 100%">
				<div class="text-header">{{ title }}</div>
				<div>{{ subtitle }}</div>
			</div>
		</div>
	</div>
</template>
