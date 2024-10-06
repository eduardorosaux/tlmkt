<template>
	<main class="main-wrapper chat_wrapper">
		<div class="chatpage-wrapper active">
			<div class="container-fluid">
				<div class="row row--0">
					<!-- Left Sidebar -->
					<div class="sp-left-sidebar popup-dashboardleft-section" style="margin-left: 80px">
						<div class="inner-wrapper position-relative">
							<left_sidebar @fetch-user-messages="fetchMessages" :staffs="data.staffs" :tags="data.tags"></left_sidebar>
						</div>
						<span class="sidebar-toggler chat-flyouttoggle d-none">
							<span class="icon">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M16 6H3" stroke="#7E7F92" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
									<path d="M21 12H3" stroke="#7E7F92" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
									<path d="M18 18H3" stroke="#7E7F92" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
								</svg>
							</span>
						</span>
					</div>
					<!-- Chat Main -->
					<div>
						<div class="sp-chat-main-wrapper" ref="chatBody" v-show="data.chat_room_id">
							<chat_messages
								@load-templates="loadMoreTemplate"
								:templates="data.templates"
								:chat_room_id="data.chat_room_id"
								:staffs="data.staffs"
								:messageScroller="data.message_scroller"
								:messageSender="data.message_sender"
								:template_search="data.template_search"
							></chat_messages>
							<msg_sender @send-messages="sendMessages" :chat_room_id="data.chat_room_id"></msg_sender>
						</div>
					</div>
					<!-- Right Sidebar -->
					<right_sidebar v-if="data.chat_room_id" :chat_room_id="data.chat_room_id"></right_sidebar>
				</div>
			</div>
		</div>
	</main>
</template>

<script setup>
// import { ref, onMounted, reactive } from "vue";
import { ref, onMounted, reactive, watch } from "vue";

import globalValue from "../mixins/helper.js";
import left_sidebar from "../partials/left_sidebar.vue";
import right_sidebar from "../partials/right_sidebar.vue";
import msg_sender from "../partials/message_sender.vue";
import chat_messages from "../partials/messages.vue";
const emit = defineEmits(["closeAllModals", "loadNewMessages"]);
const getMixinValue = globalValue();
const chatBody = ref(null);
// Define props
const props = defineProps({
	template_search: String, // Assuming template_search is of type String
});

onMounted(() => {
	getStaffs();
	getTags();
	templates();
	var chatContentBody = chatBody.value;
	if (chatContentBody) {
		// Add scroll event listener only if the element exists
		chatContentBody.addEventListener("scroll", function () {
			if (this.scrollTop == 0) {
				data.message_scroller++;
			}
		});
	}
});
const data = reactive({
	canned_responses: [],
	templates: {
		data: [],
		loading: false,
		next_page_url: false,
	},
	staffs: [],
	tags: [],
	chat_room_id: "",
	message_scroller: 0,
	message_sender: 0,
	template_search: props.template_search ?? "", // Ensure it's initialized properly
});
watch(
	() => data.template_search,
	(newValue, oldValue) => {
		if (newValue !== null) {
			templates(); // Call your templates function here
		}
	}
);

async function getStaffs() {
	if (data.staffs.length > 0) {
		return;
	}
	let url = getMixinValue.getUrl("staffs-by-client");
	await axios.get(url).then((response) => {
		getMixinValue.config.loading = false;
		if (response.data.error) {
			return alert(response.data.error);
		} else {
			data.staffs = response.data.staffs;
		}
	});
}
async function getTags() {
	if (data.tags.length > 0) {
		return;
	}
	let url = getMixinValue.getUrl("tags");
	await axios.get(url).then((response) => {
		getMixinValue.config.loading = false;
		if (response.data.error) {
			return alert(response.data.error);
		} else {
			data.tags = response.data.tags;
		}
	});
}

async function templates(load_more = false) {
	data.templates.loading = true;
	let url = getMixinValue.getUrl("whatsapp-templates");
	// Append search query if present
	if (data.template_search) {
		url += `?search=${data.template_search}`;
	}
	// Use the next page URL if loading more
	if (load_more) {
		url = load_more;
	}
	try {
		const response = await axios.get(url);
		data.templates.loading = false;

		if (response.data.success) {
			if (load_more) {
				data.templates.data = data.templates.data.concat(response.data.templates);
			} else {
				data.templates.data = response.data.templates;
			}
			data.templates.next_page_url = response.data.next_page_url;
		}
	} catch (error) {
		data.templates.loading = false;
		console.error("Error fetching templates:", error);
	}
}

function fetchMessages(args) {
	data.chat_room_id = args.chat_room_id;
}
function sendMessages(args) {
	data.message_sender += args.message_sender;
}
function loadMoreTemplate(args) {
	templates(args.url);
}
</script>
