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
            // OUTSIDE
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
                        "text": "",
                        "sceneId": "outside entrance 2"
                    }
                ]
            },
            // OUTSIDE ENTRANCE 2
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
                        "text": "",
                        "sceneId": "outside"
                    },
                    {
                        "pitch": -10,
                        "yaw": 35,
                        "type": "scene",
                        "text": "",
                        "sceneId": "outside reception"
                    }
                ]
            },
            // OUTSIDE RECEPTION
            "outside reception": {
                "panorama": "/storage/360_images/IMG_20250508_150635_352.jpg",
                "yaw": savedScene === "outside reception" ? savedYaw : 200,
                "pitch": savedScene === "outside reception" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -15,
                        "yaw": 260,
                        "type": "scene",
                        "text": "",
                        "sceneId": "outside entrance 2"
                    },
                    {
                        "pitch": -15,
                        "yaw": 155,
                        "type": "scene",
                        "text": "",
                        "sceneId": "entrance"
                    },
                    {
                        "pitch": -15,
                        "yaw": 70,
                        "type": "scene",
                        "text": "end",
                        "sceneId": "end"
                    }
                  
                ]
            },
            // ENTRANCE
           "entrance": {
                "title": "Front Entrance",
                "panorama": "/storage/360_images/IMG_20250508_150723_434.jpg",
                "yaw": savedScene === "entrance" ? savedYaw : 0,
                "pitch": savedScene === "entrance" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -15,
                        "yaw": 20,
                        "type": "scene",
                        "text": "",
                        "sceneId": "outside reception"
                    },
                    {
                        "pitch": -30,
                        "yaw": 150,
                        "type": "scene",
                        "text": "Waiting Area",
                        "sceneId": "waiting area"
                    }
                ]
            },
            // WAITING AREA
              "waiting area": {
                "title": "Waiting Area",
                "panorama": "/storage/360_images/IMG_20250508_150721_289.jpg",
                "yaw": savedScene === "waiting area" ? savedYaw : 0,
                "pitch": savedScene === "waiting area" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -30,
                        "yaw": -45,
                        "type": "scene",
                        "text": "",
                        "sceneId": "entrance"
                    },
                    {
                        "pitch": -25,
                        "yaw": 160,
                        "type": "scene",
                        "text": "Lobby",
                        "sceneId": "lobby"
                    }
                ]
            },
            // LOBBY
            "lobby": {
                "title": "Lobby",
                "panorama": "/storage/360_images/IMG_20250508_150719_027.jpg",
                "yaw": savedScene === "lobby" ? savedYaw : 0,
                "pitch": savedScene === "lobby" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": -5,
                        "type": "scene",
                        "text": "",
                        "sceneId": "waiting area"
                    },
                    {
                        "pitch": -20,
                        "yaw": 175,
                        "type": "scene",
                        "text": "", // diretso sa main entrance na
                        "sceneId": "pool1"
                    }
                ]
            },
            // POOL1
            "pool1": {
                "title": "Pool 1",
                "panorama": "/storage/360_images/IMG_20250508_150717_137.jpg",
                "yaw": savedScene === "pool1" ? savedYaw : 0,
                "pitch": savedScene === "pool1" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": -73,
                        "type": "scene",
                        "text": "",
                        "sceneId": "lobby"
                    },
                    {
                        "pitch": -20,
                        "yaw": 130,
                        "type": "scene",
                        "text": "", // extended pool1
                        "sceneId": "extended pool 1"
                    }
                ]
            },
            // EXTENDED POOL1
            "extended pool 1": {
                "panorama": "/storage/360_images/IMG_20250508_150714_980.jpg",
                "yaw": savedScene === "pool1" ? savedYaw : 0,
                "pitch": savedScene === "pool1" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": -25,
                        "type": "scene",
                        "text": "",
                        "sceneId": "pool1"
                    },
                    {
                        "pitch": -20,
                        "yaw": 120,
                        "type": "scene",
                        "text": "", // cottages
                        "sceneId": "cottages"
                    }
                ]
            },
            // COTTAGES
            "cottages": {
                "title": "Cottages",
                "panorama": "/storage/360_images/IMG_20250508_150712_818.jpg",
                "yaw": savedScene === "cottages" ? savedYaw : 0,
                "pitch": savedScene === "cottages" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": -70,
                        "type": "scene",
                        "text": "",
                        "sceneId": "extended pool 1"
                    },
                    {
                        "pitch": -15,
                        "yaw": 85,
                        "type": "scene",
                        "text": "", // cr
                        "sceneId": "cr"
                    },
                    {
                        "pitch": -15,
                        "yaw": 30,
                        "type": "scene",
                        "text": "pool 2",
                        "sceneId": "pool 2"
                    },
                    {
                        "pitch": -5,
                        "yaw": 40,
                        "type": "scene",
                        "text": "pool 3",
                        "sceneId": "pool 3"
                    }
                    
                ]
            },

            // POOL 2
            "pool 2": {
                "title": "Pool 2",
                "panorama": "/storage/360_images/IMG_20250508_150625_295.jpg",
                "yaw": savedScene === "pool 2" ? savedYaw : 0,
                "pitch": savedScene === "pool 2" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -30,
                        "yaw": 165,
                        "type": "scene",
                        "text": "",
                        "sceneId": "cottages"
                    }
                  
                ]
            },

             // POOL 3
             "pool 3": {
                "title": "Pool 3",
                "panorama": "/storage/360_images/IMG_20250508_150627_551.jpg",
                "yaw": savedScene === "pool 3" ? savedYaw : 0,
                "pitch": savedScene === "pool 3" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -30,
                        "yaw": 165,
                        "type": "scene",
                        "text": "",
                        "sceneId": "cottages"
                    }
                  
                ]
            },

            // CR
            "cr": {
                "title": "Comfort Rooms",
                "panorama": "/storage/360_images/IMG_20250508_150710_760.jpg",
                "yaw": savedScene === "cr" ? savedYaw : 0,
                "pitch": savedScene === "cr" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": -40,
                        "type": "scene",
                        "text": "",
                        "sceneId": "cottages"
                    },
                    {
                        "pitch": -15,
                        "yaw": 135,
                        "type": "scene",
                        "text": "", // hallway
                        "sceneId": "hallway"
                    }
                ]
            },
            // HALLWAY 1
            "hallway": {
                "title": "Hallway to Rooms",
                "panorama": "/storage/360_images/IMG_20250508_150708_899.jpg",
                "yaw": savedScene === "hallway" ? savedYaw : 0,
                "pitch": savedScene === "hallway" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": -65,
                        "type": "scene",
                        "text": "",
                        "sceneId": "cr"
                    },
                    {
                        "pitch": -15,
                        "yaw": 96,
                        "type": "scene",
                        "text": "", // hallway2
                        "sceneId": "hallway2"
                    }
                ]
            },
            // HALLWAY 2
            "hallway2": {
                "title": "Hallway 2",
                "panorama": "/storage/360_images/IMG_20250508_150707_134.jpg",
                "yaw": savedScene === "hallway2" ? savedYaw : 0,
                "pitch": savedScene === "hallway2" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -16,
                        "yaw": 184,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway"
                    },
                    {
                        "pitch": -30,
                        "yaw": 38,
                        "type": "scene",
                        "text": "", // hallway3
                        "sceneId": "hallway3"
                    }
                ]
            },
            // HALLWAY 3
            "hallway3": {
                "title": "Hallway 3",
                "panorama": "/storage/360_images/IMG_20250508_150705_339.jpg",
                "yaw": savedScene === "hallway3" ? savedYaw : 0,
                "pitch": savedScene === "hallway3" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -28,
                        "yaw": 105,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway2"
                    },
                    {
                        "pitch": -15,
                        "yaw": -107,
                        "type": "scene",
                        "text": "", // hallway
                        "sceneId": "hallway4"
                    },
                    {
                        "pitch": -15,
                        "yaw": 210,
                        "type": "scene",
                        "text": "", // sa gitna ng events place
                        "sceneId": "eventsplace"
                    }
                    
                ]
            },
            // HALLWAY 4
            "hallway4": {
                "title": "Hallway 4",
                "panorama": "/storage/360_images/IMG_20250508_150701_732.jpg",
                "yaw": savedScene === "hallway4" ? savedYaw : 0,
                "pitch": savedScene === "hallway4" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": -55,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway3"
                    },
                    {
                        "pitch": -10,
                        "yaw": 128,
                        "type": "scene",
                        "text": "", // hallway5
                        "sceneId": "hallway5"
                    },
                    {
                        "pitch": -30,
                        "yaw": 270,
                        "type": "scene",
                        "text": "Family Room", // family room
                        "sceneId": "familyroom"
                    }
                    
                ]
            },
            // EVENTSPLACE
            "eventsplace": {
                "title": "Event's Place",
                "panorama": "/storage/360_images/IMG_20250508_150703_560.jpg",
                "yaw": savedScene === "eventsplace" ? savedYaw : 0,
                "pitch": savedScene === "eventsplace" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -11,
                        "yaw": -32,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway3"
                    }
                  
                ]
            },
            // FAMILYROOM
            "familyroom": {
                "title": "Family Room",
                "panorama": "/storage/360_images/IMG_20250508_150655_823.jpg",
                "yaw": savedScene === "familyroom" ? savedYaw : 0,
                "pitch": savedScene === "familyroom" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -30,
                        "yaw": 180,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway4"
                    }
                  
                ]
            },
            // HALLWAY5
            "hallway5": {
                "title": "Hallway 5",
                "panorama": "/storage/360_images/IMG_20250508_150659_797.jpg",
                "yaw": savedScene === "hallway5" ? savedYaw : 0,
                "pitch": savedScene === "hallway5" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -10,
                        "yaw": 70,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway4"
                    },
                    {
                        "pitch": -30,
                        "yaw": 180,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway6"
                    }
                  
                ]
            },

            // HALLWAY6
            "hallway6": {
                "title": "Hallway 6",
                "panorama": "/storage/360_images/IMG_20250508_150657_828.jpg",
                "yaw": savedScene === "hallway6" ? savedYaw : 0,
                "pitch": savedScene === "hallway6" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -30,
                        "yaw": 240,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway5"
                    },
                    {
                        "pitch": -10,
                        "yaw": 50,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway7"
                    }
                  
                ]
            },

            // HALLWAY7
            "hallway7": {
                "title": "Hallway 7",
                "panorama": "/storage/360_images/IMG_20250508_150652_239.jpg",
                "yaw": savedScene === "hallway7" ? savedYaw : 0,
                "pitch": savedScene === "hallway7" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": 55,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway6"
                    },
                    {
                        "pitch": -5,
                        "yaw": 168.5,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway8"
                    },
                    {
                        "pitch": -20,
                        "yaw": 189,
                        "type": "scene",
                        "text": "Couple Room",
                        "sceneId": "coupleroom"
                    }
                  
                ]
            },
            
            // COUPLEROOM
            "coupleroom": {
                "title": "couple Room",
                "panorama": "/storage/360_images/IMG_20250508_150653_805.jpg",
                "yaw": savedScene === "coupleroom" ? savedYaw : 0,
                "pitch": savedScene === "coupleroom" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -30,
                        "yaw": 140,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway7"
                    }
                  
                ]
            },

            // HALLWAY8
            "hallway8": {
                "title": "Hallway 8",
                "panorama": "/storage/360_images/IMG_20250508_150648_080.jpg",
                "yaw": savedScene === "hallway8" ? savedYaw : 0,
                "pitch": savedScene === "hallway8" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -10,
                        "yaw": -33,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway7"
                    },
                    {
                        "pitch": -20,
                        "yaw": 170,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway9"
                    }
                  
                ]
            },

            // HALLWAY9
            "hallway9": {
                "title": "Hallway 9",
                "panorama": "/storage/360_images/IMG_20250508_150646_330.jpg",
                "yaw": savedScene === "hallway8" ? savedYaw : 0,
                "pitch": savedScene === "hallway8" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -10,
                        "yaw": 80,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway8"
                    },
                    {
                        "pitch": -20,
                        "yaw": 235,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway10"
                    }
                  
                ]
            },

            // HALLWAY10
            "hallway10": {
                "title": "Hallway 10",
                "panorama": "/storage/360_images/IMG_20250508_150644_254.jpg",
                "yaw": savedScene === "hallway10" ? savedYaw : 0,
                "pitch": savedScene === "hallway10" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -10,
                        "yaw": 80,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway8"
                    },
                    {
                        "pitch": -10,
                        "yaw": 251,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway11"
                    }
                  
                ]
            },

            // HALLWAY11
            "hallway11": {
                "title": "Hallway 11",
                "panorama": "/storage/360_images/IMG_20250508_150642_194.jpg",
                "yaw": savedScene === "hallway11" ? savedYaw : 0,
                "pitch": savedScene === "hallway11" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -5,
                        "yaw": 21,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway10"
                    },
                    {
                        "pitch": -10,
                        "yaw": 200,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway12"
                    }
                  
                ]
            },

            // HALLWAY12
            "hallway12": {
                "title": "Hallway 12",
                "panorama": "/storage/360_images/IMG_20250508_150639_837.jpg",
                "yaw": savedScene === "hallway12" ? savedYaw : 0,
                "pitch": savedScene === "hallway12" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -10,
                        "yaw": 11,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway11"
                    },
                    {
                        "pitch": -5,
                        "yaw": 180,
                        "type": "scene",
                        "text": "",
                        "sceneId": "end"
                    }
                  
                ]
            },

            // END
            "end": {
                "title": "END",
                "panorama": "/storage/360_images/IMG_20250508_150637_466.jpg",
                "yaw": savedScene === "end" ? savedYaw : 0,
                "pitch": savedScene === "end" ? savedPitch : 0,
                "autoLoad": true,
                "hotSpots": [
                    {
                        "pitch": -20,
                        "yaw": -9,
                        "type": "scene",
                        "text": "",
                        "sceneId": "hallway12"
                    },
                    {
                        "pitch": -20,
                        "yaw": 150,
                        "type": "scene",
                        "text": "",
                        "sceneId": "outside reception"
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