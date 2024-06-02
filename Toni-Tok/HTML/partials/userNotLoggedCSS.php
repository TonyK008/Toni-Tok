.profileButton:hover #dropdownContent {
    height: 8vw;
    box-shadow: 0vw 1vw 2vw 1vw rgba(0, 0, 0, 0.2);
    transition: height 0.4s ease-in;
}

@media (max-width: 1000px){
    .profileButton:hover #dropdownContent {
        max-height: 2vh;
    }
}

@media (max-height: 900px){
    .profileButton:hover #dropdownContent {
        max-height: 12.5vh;
    }
}