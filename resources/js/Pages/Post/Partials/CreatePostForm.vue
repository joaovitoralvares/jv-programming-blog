<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import Editor from "@tinymce/tinymce-vue";


const props = defineProps({
  user: Object,
});

const form = useForm({
  _method: "POST",
  title: null,
  summary: null,
  content: '',
  published: true
});

const createPost = () => {
  form.post(route("posts.store"), {
    errorBag: "createPost",
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
  form.content = null;
};

const handlePublished = (event) => {
  form.published = event.target.checked;
};
</script>

<template>
  <JetFormSection @submitted="createPost">
    <template #title>
         Create your blog post 
    </template>

    <template #description> Here, you can write your blog post with a powerful HTML editor </template>

    <template #form>
      <!-- Name -->
      <div class="col-span-6">
        <JetLabel for="title" value="Title" />
        <JetInput
          id="title"
          v-model="form.title"
          type="text"
          class="mt-1 block w-full"
          autocomplete="title"
        />
        <JetInputError :message="form.errors.title" class="mt-2" />
      </div>

      <!-- Summary -->
      <div class="col-span-6">
        <JetLabel for="summary" value="Summary" />
        <JetInput
          id="summary"
          v-model="form.summary"
          type="text"
          class="mt-1 block w-full"
        />
        <JetInputError :message="form.errors.summary" class="mt-2" />
      </div>

      <div class="col-span-6">
        <JetLabel for="content" value="Content" />
        <Editor
          api-key=""
          :init="{
            height: 500,
            menubar: false,
            plugins: [
              'advlist autolink lists link image charmap print preview anchor',
              'searchreplace visualblocks code fullscreen',
              'insertdatetime media table paste code help wordcount',
            ],
            toolbar:
              'undo redo | formatselect | image bold italic backcolor | \
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | removeformat | help',
          }"
          v-model="form.content"
        />
      </div>

      <div class="col-span-6">
        <JetLabel for="publish" value="Publish" />
        <JetInput
          id="publish"
          type="checkbox"
          class="mt-1"
          checked="checked"
          @input="handlePublished"
        />
        <JetInputError :message="form.errors.summary" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
        Saved.
      </JetActionMessage>

      <JetButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Create post
      </JetButton>
    </template>
  </JetFormSection>
</template>
