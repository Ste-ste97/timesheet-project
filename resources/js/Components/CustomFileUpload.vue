<template>
    <div class="card" style="width: 80%;">
        <FileUpload v-if="canUpload" :accept="accept" :auto="true" :disabled="existsFileLimit" :fileLimit="fileLimit"
                    :maxFileSize="maxFileSize" :multiple="selectMultipleFiles"
                    :url="route('fileUpload.store')" mode="basic" name="files[]"
                    @beforeUpload="addCustom" @upload="fetchUploadedFiles">
            <template #empty>
                <p>{{ __('Drag and drop files to here to upload.') }}</p>
            </template>
        </FileUpload>
        <UploadedFilesList :canDelete="canDelete" :files="uploadedFiles" @fileDeleted="removeFile"/>
    </div>
</template>

<script>
import UploadedFilesList from './UploadedFilesList.vue';

export default {
    components : {
        UploadedFilesList,
    },
    props      : {
        accept              : {
            type     : String,
            required : false,
            default  : '.pdf'
        },
        model               : {
            type     : String,
            required : true
        },
        modelId             : {
            type     : Number,
            required : false
        },
        uploadType          : { // example: 'network_file'
            type     : String,
            required : true
        },
        canUpload           : {
            type    : Boolean,
            default : true
        },
        canDelete           : {
            type    : Boolean,
            default : true
        },
        fileLimit           : {
            type    : Number,
            default : 10
        },
        maxFileSize         : {
            type    : Number,
            default : 100000000
        },
        selectMultipleFiles : {
            type    : Boolean,
            default : false,
        }
    },
    data() {
        return {
            uploadedFiles : [],
        };
    },
    methods  : {
        addCustom(event) {
            if (this.modelId !== undefined && this.modelId > 0) {
                event.formData.append('model_id', this.modelId)
            }
            event.formData.append('model', this.model)
            event.formData.append('upload_type', this.uploadType)
        },
        async fetchUploadedFiles() {
            try {
                const params = {
                    model       : this.model,
                    upload_type : this.uploadType
                }

                if (this.modelId !== undefined && this.modelId > 0) {
                    params.model_id = this.modelId
                }

                const response = await axios.get(route('fileUpload.index'), {
                    params
                });

                this.uploadedFiles = response.data
                this.$emit('onFileChange', this.uploadedFiles);
            } catch (error) {
                console.error('Error fetching uploaded files:', error);
            }
        },
        async removeFile(fileId) {
            try {
                await axios.delete((route('fileUpload.destroy', fileId)));
                this.$emit('fileDeleted', fileId);
            } catch (error) {
                console.error('Error deleting file:', error);
            }
            this.uploadedFiles = this.uploadedFiles.filter(file => file.id !== fileId);
            this.$emit('onFileChange', this.uploadedFiles);
        },
    },
    computed : {
        existsFileLimit() {
            return this.uploadedFiles.length >= this.fileLimit;
        }
    },
    mounted() {
        this.fetchUploadedFiles();
    },
};
</script>
