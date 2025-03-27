<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FilmController extends Controller
{
    public function streamVideo(Request $request)
    {
        // Get the film_id from the URL
        $filmId = '1'; // $request->film_id;

        // Get the video URL for the given film ID
        $videoUrl = $this->getVideoUrl($filmId);

        if (!$videoUrl) {
            abort(404, 'Film not found');
        }

        // Stream the video content from the external server
        return $this->streamExternalVideo($videoUrl);
    }

    // Example function to map film_id to video URL from the external server
    protected function getVideoUrl($filmId)
    {
        return 'https://www.w3schools.com/html/mov_bbb.mp4';
    }

    // Function to stream the video from the external URL
    protected function streamExternalVideo($videoUrl)
    {
        // Open the external video file stream
        $stream = fopen($videoUrl, 'rb');

        if (!$stream) {
            abort(404, 'Video file could not be accessed.');
        }


        // Send headers to tell the browser it's a video
        return response()->stream(function () use ($stream) {
            // Read and output the file in chunks
            while (!feof($stream)) {
                echo fread($stream, 1024 * 8); // 8 KB chunks
                ob_flush(); // Flush output buffer
                flush();    // Make sure the data is sent immediately
            }
            fclose($stream);
        }, 200, [
            'Content-Type' => 'video/mp4',
            'Cache-Control' => 'no-cache',  // Don't cache the video stream
        ]);
    }

    public function streamVideo2(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $filePath = storage_path('app/videos/' . $video->filename);

        if (!file_exists($filePath)) {
            abort(404, "Video not found");
        }

        $fileSize = filesize($filePath);
        $stream = fopen($filePath, 'rb');

        $start = 0;
        $end = $fileSize - 1;

        // Check if the request has a "Range" header
        if ($request->headers->has('Range')) {
            preg_match('/bytes=(\d+)-(\d*)/', $request->header('Range'), $matches);

            $start = (int) $matches[1]; // Get the start byte
            if (!empty($matches[2])) {
                $end = (int) $matches[2]; // Get the end byte if available
            }
        }

        // Set the correct content length
        $length = ($end - $start) + 1;

        // Move the file pointer to the requested start position
        fseek($stream, $start);

        $headers = [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
            'Content-Length' => $length,
            'Content-Range' => "bytes $start-$end/$fileSize",
        ];

        return response()->stream(function () use ($stream, $length) {
            $bufferSize = 1024 * 8; // 8KB buffer
            $bytesSent = 0;

            while (!feof($stream) && $bytesSent < $length) {
                $bytesToRead = min($bufferSize, $length - $bytesSent);
                echo fread($stream, $bytesToRead);
                flush();
                $bytesSent += $bytesToRead;
            }

            fclose($stream);
        }, 206, $headers);
    }
}
