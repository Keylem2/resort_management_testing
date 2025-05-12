<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Virtual Tour | Blue Belle Resort</title>
    <link rel="stylesheet" href="https://cdn.pannellum.org/2.5/pannellum.css">
    <style>
        html, body {
            margin: 0;
            height: 100%;
            overflow: hidden;
        }
        #panorama {
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>
<body>

<div id="panorama"></div>

<script src="https://cdn.pannellum.org/2.5/pannellum.js"></script>
<script>
    const savedScene = localStorage.getItem('lastScene') || 'outside';
    const savedYaw = parseFloat(localStorage.getItem('lastYaw')) || 0;
    const savedPitch = parseFloat(localStorage.getItem('lastPitch')) || 0;

    const viewer = pannellum.viewer('panorama', {
        "default": {
            "firstScene": savedScene,
            "sceneFadeDuration": 1000
        },
        "scenes": {
            "outside": {
                "title": "Outside Entrance",
                "panorama": "/storage/360_images/IMG_20250508_150629_488.jpg",
                "yaw": savedScene === "outside" ? savedYaw : 0,
                "pitch": savedScene === "outside" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": 95,
                        "type": "scene",
                        "text": "Go further",
                        "sceneId": "outside entrance 2"
                    }
                ]
            },

            "outside entrance 2": {
                "title": "Outside Entrance 2",
                "panorama": "/storage/360_images/IMG_20250508_150631_394.jpg",
                "yaw": savedScene === "outside entrance 2" ? savedYaw : 0,
                "pitch": savedScene === "outside entrance 2" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -15,
                        "yaw": 205,
                        "type": "scene",
                        "text": "Back to Outside",
                        "sceneId": "outside"
                    },
                    {
                        "pitch": -10,
                        "yaw": 35,
                        "type": "scene",
                        "text": "Go to Entrance",
                        "sceneId": "outside reception"
                    }
                ]
            },

            "outside reception": {
                "title": "Outside Reception",
                "panorama": "/storage/360_images/IMG_20250508_150635_352.jpg",
                "yaw": savedScene === "outside reception" ? savedYaw : 0,
                "pitch": savedScene === "outside reception" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -15,
                        "yaw": 260,
                        "type": "scene",
                        "text": "Back to Outside Entrance 2",
                        "sceneId": "outside entrance 2"
                    },
                    {
                        "pitch": -15,
                        "yaw": 155,
                        "type": "scene",
                        "text": "Go to Entrance",
                        "sceneId": "entrance"
                    }
                ]
            },

           "entrance": {
                "title": "Entrance",
                "panorama": "/storage/360_images/IMG_20250508_150723_434.jpg",
                "yaw": savedScene === "entrance" ? savedYaw : 0,
                "pitch": savedScene === "entrance" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -15,
                        "yaw": 20,
                        "type": "scene",
                        "text": "Back to Outside Reception",
                        "sceneId": "outside reception"
                    },
                    {
                        "pitch": -15,
                        "yaw": 155,
                        "type": "scene",
                        "text": "Go to Entrance",
                        "sceneId": "entrance"
                    }
                ]
            },
            
              "entrance": {
                "title": "Entrance",
                "panorama": "/storage/360_images/IMG_20250508_150723_434.jpg",
                "yaw": savedScene === "entrance" ? savedYaw : 0,
                "pitch": savedScene === "entrance" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -15,
                        "yaw": 20,
                        "type": "scene",
                        "text": "Back to Outside Reception",
                        "sceneId": "outside reception"
                    },
                    {
                        "pitch": -15,
                        "yaw": 155,
                        "type": "scene",
                        "text": "Go to Entrance",
                        "sceneId": "entrance"
                    }
                ]
            },

            
        }
    });

    // Save scene when it changes
    viewer.on('scenechange', function(sceneId) {
        localStorage.setItem('lastScene', sceneId);
    });

    // Save view direction every 1s
    setInterval(() => {
        localStorage.setItem('lastYaw', viewer.getYaw());
        localStorage.setItem('lastPitch', viewer.getPitch());
    }, 1000);
</script>

</body>
</html>