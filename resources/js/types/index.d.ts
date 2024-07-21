import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}
export interface BookData{
    id:string;
    title:string;
    description:string;
    book_genre:string;
    price?:string
}
export interface BookGenre{
    id:string;
    name:string;
}
export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
};
