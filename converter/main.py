# dat ディレクトリ以下のファイルを読み込んで、ファイル名を表示する
import glob
import nkf

files = glob.glob("dat/*/*/??????????")
for file in files:
    with open(file, "br") as f:
        file_data = f.read()
        # nkf で file の文字コードを判定する
    output = nkf.nkf("-Sw", file_data).replace(b"<br>", b"\\n")
    # file + ".txt" というファイル名で output を保存する
    with open(file + ".txt", "bw") as f:
        f.write(output)

