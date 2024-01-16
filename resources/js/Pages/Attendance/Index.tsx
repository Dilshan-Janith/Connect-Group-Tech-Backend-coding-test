import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PrimaryButton from '@/Components/PrimaryButton';

import { Head } from '@inertiajs/react';

import { PageProps } from '@/types';

import DataTable, { TableColumn } from "react-data-table-component";

import Card from '@mui/material/Card';

import TextInput from '@/Components/TextInput';

import { useState } from 'react';
import UploadService from '../../services/FileUploadService';

export default function Dashboard({ auth, attendance }: PageProps) {

    const [currentFile, setCurrentFile] = useState<File>();
    const [progress, setProgress] = useState<number>(0);
    const [message, setMessage] = useState<string>("");

    const selectFile = (event: React.ChangeEvent<HTMLInputElement>) => {
        const { files } = event.target;
        const selectedFiles = files as FileList;
        setCurrentFile(selectedFiles?.[0]);
        setProgress(0);
    };

    const upload = () => {
        setProgress(0);
        if (!currentFile) return;

        UploadService.upload(currentFile, (event: any) => {
            setProgress(Math.round((100 * event.loaded) / event.total));
        })
        .catch((err) => {
            setProgress(0);

            if (err.response && err.response.data && err.response.data.message) {
                setMessage(err.response.data.message);
            } else {
                setMessage('Could not upload the File!');
            }
    
            setCurrentFile(undefined);
        });
    };

    interface DataRow {
        data: string;
        name: string;
        date: string;
        time_in: string;
        time_out: string;
        total_working_hours: string;
    };

    const columns:TableColumn<DataRow>[] = [
        {
            name: 'Name',
            selector: row => row.name,
            sortable: true
        },
        {
            name: 'Checkin',
            selector: row => row.date + ' - ' + (row.time_in != null ? row.time_in : 'N/A'),
        },
        {
            name: 'Checkout',
            selector: row => row.date + ' - ' + (row.time_out != null ? row.time_out : 'N/A'),
        },
        {
            name: 'Total working hours',
            selector: row => row.total_working_hours,
        }
    ];

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Attendance</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="float-right overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <Card>
                            <div className="row">
                                <div className="col-8">
                                    <TextInput
                                        name='Import Attendance'
                                        type='file'
                                        onChange={selectFile}
                                    />
                                </div>
                            </div>

                            {currentFile && (
                                <div className="my-3 progress">
                                    <div
                                        className="progress-bar progress-bar-info"
                                        role="progressbar"
                                        aria-valuenow={progress}
                                        aria-valuemin={0}
                                        aria-valuemax={100}
                                        style={{ width: progress + "%" }}
                                    >
                                        {progress}%
                                    </div>
                                </div>
                            )}

                            {message && (
                                <div className="mt-3 alert alert-secondary" role="alert">
                                    {message}
                                </div>
                            )}
                        </Card>
                    </div>
                </div>
            </div>
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="float-right overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <Card>
                            <PrimaryButton
                                disabled={!currentFile}
                                onClick={upload}
                            >Import Attendance</PrimaryButton>
                        </Card>
                    </div>
                </div>
            </div>
            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <Card>
                            <DataTable
                                title="Attendance"
                                columns={columns}
                                data={attendance}
                                pagination
                                selectableRows
                            />
                        </Card>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
