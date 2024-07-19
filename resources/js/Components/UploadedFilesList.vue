<template>
    <div v-if="files.length>0" class="uploaded-files-list">
        <h3>{{ __('Uploaded Files') }}</h3>
        <ul>
            <li v-for="file in files" :key="file.id">
                <a :href="file.url" target="_blank">{{ file.filename }}</a>
                <Button v-if="canDelete" @click="deleteFile(file.id)">Delete</Button>
            </li>
        </ul>
    </div>
    <div v-else class="uploaded-files-list">
        <p>{{ __('No files have been uploaded') }}</p>
    </div>

</template>

<script>
export default {
    props   : {
        files     : {
            type     : Array,
            required : true,
        },
        canDelete : {
            type     : Boolean,
            required : false,
            default  : true,
        },
    },
    methods : {
        async deleteFile(fileId) {
            this.$emit('fileDeleted', fileId);
        },
    },
};
</script>

<style scoped>
.uploaded-files-list {
    margin-top : 20px;
}

.uploaded-files-list ul {
    list-style : none;
    padding    : 0;
}

.uploaded-files-list li {
    display         : flex;
    justify-content : space-between;
    align-items     : center;
    padding         : 10px;
    border          : 1px solid #dddddd;
    margin-bottom   : 10px;
}
</style>
