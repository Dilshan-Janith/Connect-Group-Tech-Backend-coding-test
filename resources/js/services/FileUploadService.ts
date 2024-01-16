import http from '../http-common';

const upload = (file: File, onUploadProgress: any): Promise<any> => {
    let formData = new FormData();

    formData.append('attendance', file);

    return http.post('api/upload', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
        onUploadProgress,
    });
};

const FileUploadService = {
    upload
};

export default FileUploadService;
