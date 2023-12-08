let profileCard = document.getElementById('profileCard');
let userId = profileCard.getAttribute('data-user-id');
let profileId = profileCard.getAttribute('data-profile-id');
let startingX;
let isDragging = false;
let isAnimating = false;

profileCard.addEventListener('touchstart', startSwipe);
profileCard.addEventListener('touchmove', swipeAction);
profileCard.addEventListener('touchend', endSwipe);

profileCard.addEventListener('mousedown', startSwipe);
profileCard.addEventListener('mousemove', (e) => {
    if (isDragging) swipeAction(e);
});
profileCard.addEventListener('mouseup', (e) => {
    isDragging = false;
    endSwipe(e);
});
profileCard.addEventListener('mouseleave', (e) => {
    if (isDragging) endSwipe(e);
});

function startSwipe(event) {
    if (event.type === "mousedown") {
        isDragging = true;
    }
    startingX = (event.touches && event.touches[0]) ? event.touches[0].clientX : event.clientX;
}

function swipeAction(event) {
    let touch = (event.touches && event.touches[0]) ? event.touches[0] : event;
    let change = touch.clientX - startingX;

    // 1. Drehung hinzufügen
    let rotationAngle = (change / window.innerWidth) * 15; // 15 Grad maximale Drehung

    // 2. Schräges Bewegen
    let translateY = Math.abs(change) * 0.2;

    profileCard.style.transform = `translateX(${change}px) rotate(${rotationAngle}deg) translateY(${translateY}px)`;

    //if (!isAnimating) {
      //  if (change > 0) {
        //    profileCard.style.left = '-' + change + 'px';
        // } else {
        //    profileCard.style.left = change + 'px';
        // }
  //  }
}

function endSwipe(event) {
    let change = startingX - ((event.changedTouches && event.changedTouches[0]) ? event.changedTouches[0].clientX : event.clientX);

    // 3. Threshold anpassen
    let threshold = window.innerWidth / 4;

    if (!isAnimating) {
        if (Math.abs(change) > threshold) {
            if (change > 0) {
                sendMatchAction(userId, profileId, 0);
            } else {
                sendMatchAction(userId, profileId, 1);
            }
            animateSwipe(change > 0 ? -1 : 1);
        } else {
            profileCard.style.transform = 'translateX(0px) rotate(0deg) translateY(0px)';
        }
    }
}

function fetchNextProfile() {
    if (!isAnimating) {
        isAnimating = true;
        profileCard.style.display = "none";
        fetch('../fetchProfile.php?continue=1')
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                if (data.endOfProfiles) {
                    window.location.href = "../resultate.php";
                } else if (data && !data.error) {
                    setTimeout(() => {
                        updateProfileOnPage(data);
                        profileCard.style.transition = 'none';
                        profileCard.style.left = '0px';
                        profileCard.style.display = "block";
                        isAnimating = false;
                        profileCard.style.pointerEvents = 'auto';
                    }, 10);
                } else {
                    console.error('No profile found:', data.error);
                }
            })
            .catch(error => {
                console.error('Error fetching profile:', error);
            });
    }
}

function updateProfileOnPage(data) {
    userId = profileCard.getAttribute('data-user-id');
    profileId = data.id;
    document.getElementById('profileTitle').innerText = data.title;
    document.getElementById('categoryButton').innerText = data.category;
    document.getElementById('profileCard').style.backgroundImage = "url('" + data.image + "')";
    profileCard.style.transform = 'translateX(0px) rotate(0deg) translateY(0px)';
}

function animateSwipe(direction) {
    let change = direction * window.innerWidth;
    let animationTime = 300;

    profileCard.style.pointerEvents = 'none';
    profileCard.style.transition = `transform ${animationTime}ms`;
    profileCard.style.transform = `translateX(${change}px) rotate(${direction * 15}deg) translateY(0px)`;

    setTimeout(() => {
        fetchNextProfile();
        profileCard.style.pointerEvents = 'auto';
    }, animationTime);
}

function dislikeProfile() {
    animateSwipe(-1);
    sendMatchAction(userId, profileId, 0);
}

function likeProfile() {
    animateSwipe(1);
    sendMatchAction(userId, profileId, 1);
}

function saveSwipePreference(preference) {
    var existingPreferences = localStorage.getItem('swipePreferences');
    var preferencesArray = existingPreferences ? JSON.parse(existingPreferences) : [];
    preferencesArray.push(preference);
    localStorage.setItem('swipePreferences', JSON.stringify(preferencesArray));
}

var swipePreferences = localStorage.getItem('swipePreferences');
// console.log('Gespeicherte Benutzerpräferenzen:', swipePreferences);
localStorage.clear();

    function sendMatchAction(userId, profileId, action) {
    let data = {
        'user_id': userId,
        'profile_id': profileId,
        'action': action
    };

    // console.log("Sending data:", data);


    $.ajax({
        type: "POST",
        url: "handle_match.php",
        data: data,
        success: function(response) {
            console.log(response);
        },
        error: function(error) {
            console.error("Fehler beim Senden der Daten: ", error);
        }
    });
}

// console.log("User ID:", userId);
// console.log("Profile ID:", profileId);
