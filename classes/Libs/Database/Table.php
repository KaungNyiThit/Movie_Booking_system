<?php

namespace Libs\Database;

class Table {

    private $db;

    public function __construct(MySQL $db){
        $this->db = $db->connect();
    }

    public function register($data){
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $statement = $this->db->prepare("INSERT INTO users(username, email, password, phone) VALUES(:username, :email,:password, :phone)");
        $statement->execute($data);

        return $this->db->lastInsertId();
        
    }

    public function login($email, $password){
        $statement = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        if($user){
            if(password_verify($password, $user->password)){
                return $user;
            }else{
                return false;
            }
        }
    }

    public function addMovie($data){
        $statement = $this->db->prepare(
            "INSERT INTO movies(title, genre, duration, poster, theater_id, trailer)
            VALUES(:title, :genre, :duration, :poster, :theater_id, :trailer)"
        );
        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function allMovies(){
        $statement = $this->db->query("SELECT * FROM movies");
        return $statement->fetchAll();
    }

    public function addTheater($data){
        $statement = $this->db->prepare(
            "INSERT INTO theaters(name, location)
            VALUES(:name, :location)"
        );
        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function allTheaters(){
        $statement = $this->db->query("SELECT * FROM theaters");
        return $statement->fetchAll();
    }

    public function getMoviesByTheater($theater_id){
        $statement = $this->db->prepare("SELECT * FROM movies WHERE theater_id = :theater_id");
        $statement->execute(['theater_id' => $theater_id]);
        return $statement->fetchAll();
    }

    public function getAllMoviesWithTheater($id){
        $statement = $this->db->prepare(
            "SELECT movies.*, theaters.name as theater_name, theaters.location as theater_location
            FROM movies LEFT JOIN theaters ON movies.theater_id = theaters.id WHERE movies.id = :id"
        );
        $statement->execute(['id' => $id]);
        return $statement->fetch() ;

    }

    public function addShowTime($data){
        $statement = $this->db->prepare(
            "INSERT INTO showtimes(movie_id, theater_id, show_time) VALUES(:movie_id, :theater_id, :show_time)"
        );

        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function getShowTimes($id){
        $statement = $this->db->prepare("SELECT * FROM showtimes WHERE movie_id = :id ");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
        
    }

    public function bookMovie($data){
        $statement = $this->db->prepare(
            "INSERT INTO bookings(seat, seat_type, price, user_id, movie_id, showtime_id, theater_id) VALUES(:seat, :seat_type, :price,:user_id, :movie_id, :showtime_id, :theater_id)"
        );
        $statement->execute($data);

        $statement = $this->db->prepare("UPDATE seats SET is_booked=1 WHERE seat=:seat AND movie_id=:movie_id");
        $statement->execute(['seat' => $data['seat'], 'movie_id' => $data['movie_id']]);

        return $this->db->lastInsertId();
    }


    public function addSeat($data){
        
        $statement = $this->db->prepare(
            "SELECT * FROM seats WHERE seat=:seat AND movie_id=:movie_id"
        );
        $statement->execute(['seat' => $data['seat'], 'movie_id' => $data['movie_id']]);
        $seat = $statement->fetchColumn();

        if($seat > 0){
            return false;
        }else{
            $statement = $this->db->prepare(
                "INSERT INTO seats(seat, seat_type,price, movie_id, is_booked) VALUES(:seat, :seat_type, :price, :movie_id, :is_booked)"
            );
            $statement->execute($data);
            return $this->db->lastInsertId();
        }

    }
    

    public function getavaliableSeats($seat_type, $id){
        $statement = $this->db->prepare("SELECT * FROM seats WHERE seat_type=:seat_type AND movie_id=:id AND is_booked=0");
        $statement->execute(['seat_type' => $seat_type, 'id' => $id]);
        return $statement->fetchAll();
    }
    
    public function getAll($id){
        $statement = $this->db->prepare("SELECT showtimes.id AS showtime_id , movies.id AS movie_id, theaters.id AS theater_id FROM showtimes LEFT JOIN movies ON showtimes.movie_id = movies.id LEFT JOIN theaters ON showtimes.theater_id = theaters.id WHERE showtimes.movie_id = :id");
        $statement->execute(['id' => $id]);
        return $statement->fetch();
    }

    public function getBookings($id){
        $statement = $this->db->prepare(
            "SELECT bookings.*, movies.title as movie_title, theaters.name as theater_name,
            showtimes.show_time as show_time FROM bookings LEFT JOIN movies ON bookings.movie_id = movies.id LEFT JOIN theaters ON bookings.theater_id = theaters.id LEFT JOIN showtimes ON bookings.showtime_id = showtimes.id WHERE bookings.user_id = :id"
        );
        $statement->execute(['id' => $id]);
        return $statement->fetchAll();
    }

    public function delete($id){
        $statement = $this->db->prepare(
            "DELETE FROM movies WHERE id=:id"
        );
        $statement->execute(['id' => $id]);


        $statement = $this->db->prepare(
            "DELETE FROM showtimes WHERE movie_id=:id"
        );
        $statement->execute(['id' => $id]);

        $statement = $this->db->prepare(
            "DELETE FROM bookings WHERE movie_id=:id"
        );
        $statement->execute(['id' => $id]);

        $statement = $this->db->prepare(
            "DELETE FROM seats WHERE movie_id=:id"
        );

        return $this->db->lastInsertId();
    }

}